<?php

namespace App\Console\Commands;

use App\Http\Controllers\Api\ApiNotificationsController;
use App\Http\Controllers\WebSocketPusherController;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use function Sebwite\Support\Str;

class ParseMigrationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse_migrations --connection=';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse Migrations';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle(): bool
    {
        $fs = new Filesystem();
        $connNames = ['mysql', 'mysqlu'];
        $connection = $this->anticipate('Please enter connection name', $connNames);

        $conn = \DB::connection($connection)->getDoctrineSchemaManager();
        $conn->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        $tables = $conn->listTableNames();

        if (!in_array($connection, $connNames)) {
            $this->error('Connection doesn`t exist');
            return false;
        }

        foreach ($tables as $table) {
            $ucTablename = ucfirst(Str::camel($table));
            $parsedTemplate = str_replace('{ucTablename}', $ucTablename, self::getTemplate());
            $parsedTemplate = str_replace('{lcTablename}', $table, $parsedTemplate);
            $parsedTemplate = str_replace('{connection}', $connection, $parsedTemplate);
            $parsedTemplate = str_replace('{uConnection}', ucfirst($connection), $parsedTemplate);

            $foreignKeysTemplate = str_replace('{ucTablename}', $ucTablename, self::getForeignKeysTemplate());
            $foreignKeysTemplate = str_replace('{lcTablename}', $table, $foreignKeysTemplate);
            $foreignKeysTemplate = str_replace('{connection}', $connection, $foreignKeysTemplate);
            $foreignKeysTemplate = str_replace('{uConnection}', ucfirst($connection), $foreignKeysTemplate);

            $cols = $conn->listTableColumns($table);
            $foreigns = $conn->listTableForeignKeys($table);

            $parsedTableNames = [];

            $foreignsArray = [];
            $dropKeysArray = [];

            foreach ($foreigns as $foreign) {
                $foreignTemplate = str_replace('{ucTablename}', $ucTablename, self::hasKeys());
                $foreignTemplate = str_replace('{lcTablename}', $table, $foreignTemplate);
                $foreignTemplate = str_replace('{foreign}', $foreign->getName(), $foreignTemplate);
                $foreignTemplate = str_replace('{onUpdate}', $foreign->getOptions()['onUpdate'], $foreignTemplate);
                $foreignTemplate = str_replace('{onDelete}', $foreign->getOptions()['onDelete'], $foreignTemplate);
                $foreignTemplate = str_replace('{columnName}', $foreign->getLocalColumns()[0], $foreignTemplate);
                $foreignTemplate = str_replace('{refForeignName}', $foreign->getForeignColumns()[0], $foreignTemplate);
                $foreignTemplate = str_replace('{refForeign}', $foreign->getForeignTableName(), $foreignTemplate);
                $foreignTemplate = str_replace('{connection}', $connection, $foreignTemplate);

                $keysTemplate = str_replace('{foreign}', $foreign->getName(), self::dropKeys());

                $foreignsArray[] = $foreignTemplate;
                $dropKeysArray[] = $keysTemplate;
            }

            if (!empty($foreignsArray)) {
                $foreignKeysTemplate = str_replace('{hasKeys}', implode("\n", $foreignsArray), $foreignKeysTemplate);
                $foreignKeysTemplate = str_replace('{dropKeys}', implode("\n", $dropKeysArray), $foreignKeysTemplate);

                $path = env('PUBLIC_PATH') . DS . '..' . DS . '..' . DS . 'app' . DS . 'Database' . DS . 'migrations';

                if (!$fs->exists($path)) {
                    $fs->makeDirectory($path);
                }

                $fullPath = $path . DS . '1111_11_11_111111_' . $connection . '_fk_' . $table . '.php';
                $fs->put($fullPath, $foreignKeysTemplate);
                $this->info('Table `' . $table . '` generated foreign keys data');
            }

            foreach ($cols as $column) {
                $columnType = $column->getType();
                $name = $column->getName();
                $instance = (new $columnType());
                $options = '';

                if ($column->getUnsigned() == true) {
                    $options .= '->unsigned()';
                }

                if ($column->getLength() && !in_array($instance->getName(), ['text', 'string'])) {
                    $options .= '->length(' . $column->getLength() . ')';
                }

                if ($column->getNotnull() == false) {
                    $options .= '->nullable()';
                }

                if ($column->getDefault()) {
                    $quotes = is_int($column->getDefault()) == true ? null : "\"";
                    $options = "->default({$quotes}{$column->getDefault()}{$quotes})";
                }

                if (preg_match('#_id#', $name, $matches) == 1) {
                    $options .= "->index('" . $table . "_" . $name . "_foreign')";
                }

                $parsedTableName = str_replace('{columnName}', $name, self::getTableName());

                if ($column->getName() == 'id') {
                    $parsedTableName = str_replace('{type}', "increments", $parsedTableName);
                    $parsedTableName = str_replace('{options}', '', $parsedTableName);
                } else {
                    $type = $instance->getName();
                    if ($type == 'bigint') {
                        $type = 'bigInteger';
                    }
                    if ($type == 'datetime') {
                        $type = 'dateTime';
                    }

                    $parsedTableName = str_replace('{type}', $type, $parsedTableName);
                    $parsedTableName = str_replace('{options}', $options, $parsedTableName);
                }

                $parsedTableNames[] = [
                    'string' => $parsedTableName,
                    'name' => $name
                ];
            }

            $checkedCols = [];
            foreach ($parsedTableNames as $parsedColumn) {
                $checkedCol = str_replace('{parsedColumn}', $parsedColumn['string'], self::getCheckedColumnNames());
                $checkedCol = str_replace('{lcTablename}', $table, $checkedCol);
                $checkedCol = str_replace('{columnName}', $parsedColumn['name'], $checkedCol);
                $checkedCol = str_replace('{connection}', $connection, $checkedCol);
                $checkedCols[] = $checkedCol;
            }

            $allNames = collect($parsedTableNames)->pluck('string')->toArray();

            $parsedTemplate = str_replace('{tableNames}', implode("\n", $allNames), $parsedTemplate);
            $parsedTemplate = str_replace('{checkedColumnNames}', implode("\n", $checkedCols), $parsedTemplate);

            $path = env('PUBLIC_PATH') . DS . '..' . DS . '..' . DS . 'app' . DS . 'Database' . DS . 'migrations';

            if (!$fs->exists($path)) {
                $fs->makeDirectory($path);
            }

            $fullPath = $path . DS . '0000_00_00_000000_' . $connection . '_create_' . $table . '.php';
            $fs->put($fullPath, $parsedTemplate);
            $this->info('Table `' . $table . '` generated');
        }

        return true;
    }

    public static function getTemplate(): string
    {
        return <<<txt
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class {uConnection}Create{ucTablename} extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('{connection}')->hasTable('{lcTablename}')) {
            Schema::connection('{connection}')->create('{lcTablename}', function (Blueprint \$table) {
                {tableNames}
            });
        } else {
            Schema::connection('{connection}')->table('{lcTablename}', function (Blueprint \$table) {
                {checkedColumnNames}
            });
        }
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('{connection}')->drop('{lcTablename}');
    }

}
txt;
    }

    public static function getTableName(): string
    {
        return <<<txt
        \$table->{type}('{columnName}'){options};
txt;

    }

    public static function getCheckedColumnNames(): string
    {
        return <<<txt
        if (!Schema::connection('{connection}')->hasColumn('{lcTablename}', '{columnName}')) {
                {parsedColumn}
        }
txt;

    }

    public static function getForeignKeysTemplate(): string
    {
        return <<<txt
<?php

use App\Traits\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class {uConnection}Fk{ucTablename} extends Migration
{
    use Utils;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::connection('{connection}')->table('{lcTablename}', function (Blueprint \$table) {
                {hasKeys}
            });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('{connection}')->table('{lcTablename}', function (Blueprint \$table) {
           {dropKeys}
        });
    }

}

txt;

    }

    public static function hasKeys(): string
    {
        return <<<txt
        if (!Utils::hasForeignKey('{lcTablename}', '{foreign}', '{connection}')) {
            \$table->foreign('{columnName}')->references('{refForeignName}')->on('{refForeign}')
            ->onUpdate('{onUpdate}')->onDelete('{onDelete}');
        }
txt;

    }

    public static function dropKeys(): string
    {
        return <<<txt
        \$table->dropForeign('{foreign}'); 
txt;

    }
}

<?php 

class AuthCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
    }

    public function registerTestSuccess(ApiTester $tester, \Codeception\Scenario $scenario)
    {
        $conn = Database::connections(Database::NGU_CONNECTION);
        if ($conn->fail()) {
            $scenario->incomplete($conn->err());
            return;
        }

        $conn->pdo()->query('DELETE FROM user WHERE username = "testUser"');

        $conn = Database::connections(Database::NG_CONNECTION);
        if ($conn->fail()) {
            $scenario->incomplete($conn->err());
            return;
        }
        $conn->pdo()->query('INSERT INTO domain (domain_type, name, is_default) values(1, "testDomain", 0)');

        $tester->sendPOST("register", ['login' => 'testUser', 'password' => 'testPassword', 'password_confirmation' => 'testPassword', 'domain' => 'testDomain', 'email' => '968597@gmail.com']);
        $tester->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $tester->seeResponseContainsJson(['result' => 'success', 'code' => 200, 'data' => ['username' => 'testUser']]);

        $conn = Database::connections(Database::NG_CONNECTION);
        if ($conn->fail()) {
            $scenario->incomplete($conn->err());
            return;
        }
        $conn->pdo()->query('DELETE FROM domain WHERE name = "testDomain"');
    }

    public function loginTestSuccess(ApiTester $tester, \Codeception\Scenario $scenario)
    {
        $tester->sendPOST('login', ['login' => 'testUser', 'password' => 'testPassword']);
        $tester->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $tester->seeResponseContainsJson(['result' => 'success', 'code' => 200, 'data' => ['user' => ['username' => 'testUser']]]);

        $conn = Database::connections(Database::NGU_CONNECTION);
        if ($conn->fail()) {
            $scenario->incomplete($conn->err());
            return;
        }

        $conn->pdo()->query('DELETE FROM user WHERE username = "testUser"');
    }
}

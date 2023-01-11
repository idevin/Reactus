<select id="div_section" class="form-control" name="section_id">
    <option value="">Выберите раздел...</option>
    @foreach($sections as $id => $section)
        <option value="{{$id}}">{{$section}}</option>
    @endforeach
</select>
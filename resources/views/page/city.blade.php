<!-- <select id="basic" name="city" class="city selectpicker show-tick form-control" data-live-search="true">   -->
    <option selected="selected">-- Pilih Kota --</option>
    @foreach($city as $data)
      <option value="{{$data->city_id}}" id="{{$data->city_id}}">{{ $data->city_name}}</option>
    @endforeach
  <!-- </select> -->
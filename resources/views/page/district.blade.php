<!-- <select id="basic" name="city" class="city selectpicker show-tick form-control" data-live-search="true">   -->
    <option selected="selected">-- Pilih Kecamatan --</option>
    @foreach($district as $data)
      <option value="{{$data->district_id}}" id="{{$data->district_id}}">{{ $data->district_name}}</option>
    @endforeach
  <!-- </select> -->
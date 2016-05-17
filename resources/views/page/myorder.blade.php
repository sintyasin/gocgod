@extends('layout.main_layout')

@section('content')
<div class="padding_outer">
    <div class="container">
        <h2>My Order</h2>
        <table id="" class="display table table-striped table-bordered dt-responsive" width="100%">
          <thead>
            <tr>
              <th>Product</th>
              <th>Picture</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Sub Total</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Cin Cau</td>
              <td><img src={{ URL('assets/images/product/minuman/cin_cau.jpg') }} style='height:200px;'/></td>
              <td>60000</td>
              <td align="center">
                <input type="number" min="1" value="1" style="width:40px; color:black;"> <br><br>
                <button type="button" class="btn btn-primary">Update</button>
              </td>
              <td>60000</td>
              <td align="center">
                <button type="button" class="btn btn-danger">Delete</button>
              </td>
            </tr>
            <tr>
              <td>Soya Milk</td>
              <td><img src={{ URL('assets/images/product/minuman/soya_milk.jpg') }} style='height:200px;'/></td>
              <td>75000</td>
              <td align="center">
                <input type="number" min="1" value="2" style="width:40px; color:black;"> <br><br>
                <button type="button" class="btn btn-primary">Update</button>
              </td>
              <td>150000</td>
              <td align="center">
                <button type="button" class="btn btn-danger">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
    </div>
</div>
@stop
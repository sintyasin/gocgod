<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Requests;
//use Request;
use Validator;
use Yajra\Datatables\Datatables;
//use ValidatesRequests;

use DB;
use App\Product;
use App\ProductCategory;
use App\User;
use App\City;
use App\Faq;
use App\ProductTestimonial;
use App\AgentRating;
use App\AboutUs;

class AdminController extends Controller
{
  public function getAboutUs($status)
  {
    $data['query'] = AboutUs::find(1);
    $data['status'] = $status;
    $data['active'] = 'aboutus';

    return view('page.admin_aboutus', $data);
  }

  public function postAboutUs(Request $request, $id)
  {
    $v = Validator::make($request->all(), [
        'name'    => 'required|max:100',
        'address' => 'required|max:500',
        'phone'   => 'required|numeric',
    ]);

    if ($v->fails())
    {
        //dd('b');
        return redirect('/adminaboutus/new')->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();

    $name = filter_var($input['name'], FILTER_SANITIZE_STRING);
    $address = filter_var($input['address'], FILTER_SANITIZE_STRING);
    $phone = filter_var($input['phone'], FILTER_SANITIZE_STRING);

    $aboutus = AboutUs::find($id);
    $aboutus->name = $name;
    $aboutus->address = $address;
    $aboutus->phone = $phone;


    return redirect('adminaboutus/successUpdate');
  }

  public function postEditCity(Request $request, $id)
  {
    $v = Validator::make($request->all(), [
        'city'       => 'required|max:250',
    ]);

    if ($v->fails())
    {
        return redirect('/admineditcity/' . $id)->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();

    $inputCity = filter_var($input['city'], FILTER_SANITIZE_STRING);

    $city = City::find($id);
    $city->city_name = $inputCity;
    $city->save();

    return redirect('/admincitylist/successUpdate');
  }

  public function getEditCity($id)
  {
    $data['query'] = City::find($id);
    $data['active'] = 'cityList';

    return view('page.admin_editcity', $data);
  }

  public function postInsertCity(Request $request)
  {
    $v = Validator::make($request->all(), [
        'city'       => 'required|max:250',
    ]);

    if ($v->fails())
    {
        return redirect('/admininsertcity/new')->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();

    $inputCity = filter_var($input['city'], FILTER_SANITIZE_STRING);

    $city = new City();
    $city->city_name = $inputCity;
    $city->save();

    return redirect('/admininsertcity/success');
  }

  public function insertCity($status)
  {
    $data['active'] = "insertCity";
    $data['status'] = $status;

    return view('page.admin_insertcity', $data);
  }

  public function deleteCity($id)
  {
    City::where('city_id', $id)->delete();

    return redirect()->to('admincitylist/successDelete');
  }

  public function getCityData()
  {
    $data['query'] = City::get(['city_id', 'city_name']);
        
    return Datatables::of($data['query'])
    ->make(true);
  }

  public function getCityList($status)
  {
    $data['active'] = "cityList";
    $data['status'] = $status;

    return view('admin_city', $data);
  }

  public function getReviewAgentList()
  {
    $data['query'] = AgentRating::leftJoin('master__member as a', 'master__agent_rating.agent_id', '=', 'a.id')
                                ->leftJoin('master__member as c', 'master__agent_rating.customer_id', '=', 'c.id')
                                ->where('approval', 1)
                                ->get(['rating_id', 'a.name as agent', 'c.name as customer', 'rating', 'comment']);
        
    return Datatables::of($data['query'])
    ->make(true);
  }

  public function getProcessReviewAgent($action, $array)
  {
    $data['active'] = "userReviewAgentRequest";
    $id = explode(',', $array);
    foreach ($id as $tmp) 
    {
      $review = AgentRating::find($tmp);
      if($action == "reject")
        $review->delete();
      else if($action == "approve")
      {
        $review->approval = 1;
        $review->save();
      }
    }

    if($action == "reject")
      $data['status'] = "successReject";
    else if($action == "approve")
      $data['status'] = "successApprove";

    return view('page.admin_reviewagentrequest', $data);
  }

  public function getReviewAgent($status)
  {
    $data['active'] = 'userReviewAgent';
    $data['status'] = $status;

    return view('page.admin_reviewagent', $data);
  }

  public function getDeleteReviewAgent($array)
  {
    $data['active'] = 'userReviewAgent';
    $data['status'] = 'successDelete';

    $id = explode(",", $array);
    foreach ($id as $tmp)
    {
      AgentRating::find($tmp)->delete();
    }

    return view('page.admin_reviewagent', $data);
  }

  public function getReviewAgentRequest($status)
  {
    $data['active'] = 'userReviewAgentRequest';
    $data['status'] = $status;

    return view('page.admin_reviewagentrequest', $data);
  }  

  public function getProcessReviewAgentList()
  {
    $data['query'] = AgentRating::leftJoin('master__member as a', 'master__agent_rating.agent_id', '=', 'a.id')
                                ->leftJoin('master__member as c', 'master__agent_rating.customer_id', '=', 'c.id')
                                ->where('approval', 0)
                                ->get(['rating_id', 'a.name as agent', 'c.name as customer', 'rating', 'comment']);
    
    return Datatables::of($data['query'])
    ->make(true);
  }

  public function postEditAgent(Request $request, $id)
  {
    $v = Validator::make($request->all(), [
        'status'       => 'required|numeric',
        'verification' => 'required|numeric',
    ]);    

    if ($v->fails())
    {
        return redirect('/admineditagent/' . $id)->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();

    $status = filter_var($input['status'], FILTER_SANITIZE_STRING);
    $verification = filter_var($input['verification'], FILTER_SANITIZE_STRING);

    $user = User::find($id);
    $user->status_user = $status;
    $user->verification = $verification;
    $user->save();

    return redirect('/adminagentlist/successEdit');
  }

  public function getEditAgent($id)
  {
    $data['query'] = User::find($id);
    $data['active'] = "userAgentList";

    return view('page.admin_editagent', $data);
  }

  public function getAgentList($status)
  {
      $data['active'] = "userAgentList";
      $data['status'] = $status;

      return view('page.admin_agent', $data);
  }

  public function getAgentData()
  {
      $data['query'] = User::leftJoin('master__city', 'master__member.city_id', '=', 'master__city.city_id')
                            ->where('status_user', 0)
                            ->get(['id', 'name', 'address', 'master__member.city_id', 'date_of_birth', 'email', 'phone', 'verification', 'balance', 'bank_account','city_name']);
        
      return Datatables::of($data['query'])
      ->make(true);
  }

  public function postEditCustomer(Request $request, $id)
  {
    $v = Validator::make($request->all(), [
        'status'       => 'required|numeric',
        'verification' => 'required|numeric',
    ]);    

    if ($v->fails())
    {
        return redirect('/admineditcustomer/' . $id)->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();

    $status = filter_var($input['status'], FILTER_SANITIZE_STRING);
    $verification = filter_var($input['verification'], FILTER_SANITIZE_STRING);

    $user = User::find($id);
    $user->status_user = $status;
    $user->verification = $verification;
    $user->save();

    return redirect('/admincustomerlist/successEdit');
  }

  public function getEditCustomer($id)
  {
    $data['active'] = "userMemberList";
    $data['query'] = User::find($id);

    return view('page.admin_editcustomer', $data);
  }

  public function getCustomerList($status)
  {
      $data['active'] = "userMemberList";
      $data['status'] = $status;

      return view('page.admin_customer', $data);
  }

  public function getCustomerData()
  {
      $data['query'] = User::leftJoin('master__city', 'master__member.city_id', '=', 'master__city.city_id')
                            ->where('status_user', 1)
                            ->get(['id', 'name', 'address', 'master__member.city_id', 'date_of_birth', 'email', 'phone', 'verification', 'city_name']);
        
      return Datatables::of($data['query'])
      ->make(true);
  }

  //fungsi buat FAQ
  public function getFaqList($status)
  {
      $data['active'] = "faqList";
      $data['status'] = $status;

      return view('page.admin_faq', $data);
  }

  public function getFaqData()
  {
      $data['query'] = Faq::get(['question_id', 'question', 'answer']);
        
      return Datatables::of($data['query'])
      ->make(true);
  }

  public function postInsertFaq(Request $request)
  {
    $v = Validator::make($request->all(), [
        'question' => 'required|max:10000',
        'answer' => 'required|max:10000',
    ]);    

    if ($v->fails())
    {
        return redirect('/admininsertfaq/new')->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();

    $question = filter_var($input['question'], FILTER_SANITIZE_STRING);
    $answer = filter_var($input['answer'], FILTER_SANITIZE_STRING);

    $faq = new Faq;
    $faq->question = $question;
    $faq->answer = $answer;
    $faq->save();

    return redirect('/admininsertfaq/success');
  }

  public function getEditFaq($id)
  {
    $data['query'] = Faq::find($id);
    $data['active'] = "faqList";

    return view('page.admin_editfaq', $data);
  }

  public function postEditFaq(Request $request, $id)
  {
    $v = Validator::make($request->all(), [
        'question' => 'required|max:10000',
        'answer' => 'required|max:10000',
    ]);    

    if ($v->fails())
    {
        return redirect('/admineditfaq/' . $id)->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();

    $question = filter_var($input['question'], FILTER_SANITIZE_STRING);
    $answer = filter_var($input['answer'], FILTER_SANITIZE_STRING);

    $faq = Faq::find($id);
    $faq->question = $question;
    $faq->answer = $answer;
    $faq->save();

    return redirect('/adminfaqlist/successUpdate');
  }

  public function getInsertFaq($status)
  {
    $data['active'] = 'insertFaq';
    $data['status'] = $status;

    return view ('page.admin_insertfaq', $data);
  }

  public function getDeleteFaq($id)
  {
    Faq::where('question_id', $id)->delete();
    
    return redirect()->to('adminfaqlist/successDelete');
  }

  //fungsi buat product
  public function getTestimonialList($status)
  {
    $data['status'] = $status;
    $data['active'] = 'productTestimonial';
    
    return view('page.admin_producttestimonial', $data);
  }

  public function getTestimonialData()
  {
    $data['query'] = ProductTestimonial::leftJoin('master__member', 'product__testimonial.id', '=', 'master__member.id')
                                    ->leftJoin('product__varian', 'product__testimonial.varian_id', '=', 'product__varian.varian_id')
                                    ->where('approval', 1)
                                    ->get(['varian_name', 'name', 'testimonial_id', 'testimonial']);

    return Datatables::of($data['query'])
    ->make(true);
  }

  public function getDeleteTestimoni($array)
  {
    $id = explode(',', $array);
    foreach ($id as $tmp) 
    {
      ProductTestimonial::find($tmp)->delete();
    }
    $data['active'] = "productTestimonial";
    $data['status'] = "successDelete";

    return view('page.admin_producttestimonial', $data);
  }

  public function getTestimonialRequest($status)
  {
    $data['active'] = "productTestimonialRequest";
    $data['status'] = $status;

    return view('page.admin_producttestimonialrequest', $data);
  }

  public function getProcessTestimonialData()
  {
    $data['query'] = ProductTestimonial::leftJoin('master__member', 'product__testimonial.id', '=', 'master__member.id')
                                    ->leftJoin('product__varian', 'product__testimonial.varian_id', '=', 'product__varian.varian_id')
                                    ->where('approval', 0)
                                    ->get(['varian_name', 'name', 'testimonial_id', 'testimonial']);

    return Datatables::of($data['query'])
    ->make(true);
  }

  public function getProcessTestimoni($action, $array)
  {
    $data['active'] = "productTestimonialRequest";
    $id = explode(',', $array);
    foreach ($id as $tmp) 
    {
      $testi = ProductTestimonial::find($tmp);
      if($action == "reject")
        $testi->delete();
      else if($action == "approve")
      {
        $testi->approval = 1;
        $testi->save();
      }
    }

    if($action == "reject")
      $data['status'] = "successReject";
    else if($action == "approve")
      $data['status'] = "successApprove";

    return view('page.admin_producttestimonialrequest', $data);
  }

  public function getEditCategory($id)
  {
    $data['query'] = ProductCategory::find($id);
    $data['active'] = 'productCategory';

    return view('page.admin_editcategory', $data);
  }

  public function postEditCategory(Request $request, $id)
  {
    $v = Validator::make($request->all(), [
        'description' => 'max:10000'
    ]);    

    if ($v->fails())
    {
        return redirect('/admineditcategory/' . $id)->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();

    $desc = filter_var($input['description'], FILTER_SANITIZE_STRING);

    $category = ProductCategory::find($id);
    $category->description = $desc;
    $category->save();

    return redirect('/admincategorylist/successUpdate');
  }

  public function getCategoryList($status)
  {
    $data['status'] = $status;
    $data['active'] = 'productCategory';

    return view('page.admin_productcategory', $data);
  }

  public function getCategoryData()
  {
    $data['query'] = ProductCategory::get(['category_id', 'category_name', 'description']);

    return Datatables::of($data['query'])
    ->make(true);
  }

  public function postEditProduct(Request $request, $id)
  {
    $input = $request->all();

    //kalo dia insert new category
    if($input['category'] == 0)
    {
      $v = Validator::make($request->all(), [
          'name' => 'required|max:100',
          'price' => 'required|numeric',
          'quantity' => 'required|numeric',
          'weight' => 'required|numeric',
          'description' => 'required',
          'category' => 'required|numeric',
          'picture' => 'mimes:jpg,jpeg,png',
          'newcategory' => 'required|unique:product__category,category_name|max:100',
      ]);
    }
    else
    {
      $v = Validator::make($request->all(), [
          'name' => 'required|max:100',
          'price' => 'required|numeric',
          'quantity' => 'required|numeric',
          'weight' => 'required|numeric',
          'description' => 'required',
          'category' => 'required|numeric',
          'picture' => 'mimes:jpg,jpeg,png',
      ]);
    }    

    if ($v->fails())
    {
        return redirect('/admineditproduct/' . $id)->withErrors($v->errors())->withInput();
    }    

    $name = filter_var($input['name'], FILTER_SANITIZE_STRING);
    $price = filter_var($input['price'], FILTER_SANITIZE_STRING);
    $quantity = filter_var($input['quantity'], FILTER_SANITIZE_STRING);
    $weight = filter_var($input['weight'], FILTER_SANITIZE_STRING);
    $description = filter_var($input['description'], FILTER_SANITIZE_STRING);
    $category = filter_var($input['category'], FILTER_SANITIZE_STRING);
    
    //kalo upload file baru
    if($_FILES["picture"]["error"] != 4) 
    {
      $picture = $input['picture'];

      if($picture->getClientSize() > 512000)
      {
        return redirect('/admineditproduct/' . $id)->with('errorSize', 'The picture size cannot be larger than 500 kilobytes')->withInput();
      }

      $fileName = filter_var($picture->getClientOriginalName(), FILTER_SANITIZE_STRING);
      $fileName = preg_replace('~[\\\\/:*?"<>|-]~', '', $fileName);
      $fileName = str_replace(' ', '_', $fileName);
      $fileName = time() . $fileName;
    }
    else //kalo ga upload file baru
    {
      $picture = null;
    }

    //kalo new category, berarti insert dulu category barunya
    if($category == 0)
    {
      $newcategory = filter_var($input['newcategory'], FILTER_SANITIZE_STRING);
      $newdesc = filter_var($input['newcategorydesc'], FILTER_SANITIZE_STRING);
      
      $data = new ProductCategory;
      $data->category_name = $newcategory;
      $data->description = $newdesc;
      $data->save();
    }

    $product = Product::find($id);
    //ambil data picture lama, untuk di delete gambarnya
    $oldPicture = $product->picture;
    //ambil data kategori lama, untuk di delete gambarnya
    $oldCategory = $product->category_id;


    $product->varian_name = $name;
    $product->price = $price;
    $product->qty = $quantity;
    $product->description = $description;
    $product->weight = $weight;
    if($category == 0) //kalo insert category baru
      $product->category_id = $data->category_id;
    else
      $product->category_id = $category;
    if($picture != null)
      $product->picture = $fileName;
    $product->save();

    //cek database categorynya itu apa, buat pindahin gambar
    if($picture != null)
    {
      if($category == 0) //kalo new category, berarti ambil category yang baru
        $query = ProductCategory::find($data->category_id);
      else //kalo dia pake kategori yang udah ada
        $query = ProductCategory::find($category);
      //pindahin gambarnya
      $picture->move(base_path() . '/public/assets/images/product/' . $query->category_name . '/', $fileName);
    
      //hapus file yang lama
      $category = ProductCategory::find($oldCategory);

      $path = base_path() . "/public/assets/images/product/" . $category->category_name . "/" . $oldPicture;
      $fileExist = file_exists($path);
      if($fileExist)
      {
        unlink($path);
      }
    }

    $query = Product::find($id);

    //kalo dia cuma ganti category doang, file gambarnya harus dipindah
    if($picture == null && $oldCategory != $query->category_id)
    {
      $category = ProductCategory::find($oldCategory);
      $newCategory = ProductCategory::find($product->category_id);

      $path = base_path() . "/public/assets/images/product/" . $category->category_name . "/" . $oldPicture;
      $newPath = base_path() . "/public/assets/images/product/" . $newCategory->category_name . "/" . $oldPicture;
      $fileExist = file_exists($path);
      if($fileExist)
      {
        copy($path, $newPath);
        unlink($path);
      }
    }
    return redirect('/adminproductlist/successUpdate');
  }

  public function getEditProduct($id)
  {
    $data['query'] = Product::find($id);
    $data['category'] = ProductCategory::find($data['query']->category_id);
    $data['allCategory'] = ProductCategory::all();
    $data['active'] = "productList";

    return view('page.admin_editproduct', $data);
  }

  public function postInsertProduct(Request $request)
  {
    $input = $request->all();

    //kalo dia insert new category
    if($input['category'] == 0)
    {
      $v = Validator::make($request->all(), [
          'name' => 'required|max:100',
          'price' => 'required|numeric',
          'quantity' => 'required|numeric',
          'weight' => 'required|numeric',
          'description' => 'required|alpha',
          'category' => 'required|numeric',
          'picture' => 'required|mimes:jpg,jpeg,png',
          'newcategory' => 'required|unique:product__category,category_name|max:100',
      ]);
    }
    else
    {
      $v = Validator::make($request->all(), [
          'name' => 'required|max:100',
          'price' => 'required|numeric',
          'quantity' => 'required|numeric',
          'weight' => 'required|numeric',
          'description' => 'required|alpha',
          'category' => 'required|numeric',
          'picture' => 'required|mimes:jpg,jpeg,png',
      ]);
    }    

    if ($v->fails())
    {
        return redirect('/admininsertproduct/new')->withErrors($v->errors())->withInput();
    }    

    $name = filter_var($input['name'], FILTER_SANITIZE_STRING);
    $price = filter_var($input['price'], FILTER_SANITIZE_STRING);
    $quantity = filter_var($input['quantity'], FILTER_SANITIZE_STRING);
    $weight = filter_var($input['weight'], FILTER_SANITIZE_STRING);
    $description = filter_var($input['description'], FILTER_SANITIZE_STRING);
    $category = filter_var($input['category'], FILTER_SANITIZE_STRING);
    $picture = $input['picture'];
    if($picture->getClientSize() > 512000)
    {
      return redirect('/admininsertproduct/new')->with('errorSize', 'The picture size cannot be larger than 500 kilobytes')->withInput();
    }

    $fileName = filter_var($picture->getClientOriginalName(), FILTER_SANITIZE_STRING);
    $fileName = preg_replace('~[\\\\/:*?"<>|-]~', '', $fileName);
    $fileName = str_replace(' ', '_', $fileName);
    $fileName = time() . $fileName;

    //kalo new category, berarti insert dulu category barunya
    if($category == 0)
    {
      $newcategory = filter_var($input['newcategory'], FILTER_SANITIZE_STRING);
      $newdesc = filter_var($input['newcategorydesc'], FILTER_SANITIZE_STRING);
      
      $data = new ProductCategory;
      $data->category_name = $newcategory;
      $data->description = $newdesc;
      $data->save();
    }

    $product = new Product;
    $product->varian_name = $name;
    $product->price = $price;
    $product->qty = $quantity;
    $product->description = $description;
    $product->weight = $weight;
    if($category == 0) //kalo insert category baru
      $product->category_id = $data->category_id;
    else
      $product->category_id = $category;
    $product->picture = $fileName;
    $product->save();

    //cek database categorynya itu apa, buat pindahin gambar
    if($category == 0) //kalo new category, berarti ambil category yang baru
      $query = ProductCategory::find($data->category_id);
    else //kalo dia pake kategori yang udah ada
      $query = ProductCategory::find($category);
    //pindahin gambarnya
    $picture->move(base_path() . '/public/assets/images/product/' . $query->category_name . '/', $fileName);

    return redirect('/admininsertproduct/success');
  }

  public function getDeleteProduct($id)
  {
    //pake soft delete
    Product::where('varian_id', $id)->delete();
    return redirect()->to('adminproductlist/successDelete');
  }

  public function getInsertProduct($status)
  {
    $data['query'] = ProductCategory::get(['category_id', 'category_name']);
    $data['active'] = "insertProduct";

    if($status == "success")
      $data['status'] = "success";
    else
      $data['status'] = "new";

    return view('page.admin_insertproduct', $data);
  }

  public function getProductList($status)
  {
    $data['active'] = "productList";
    $data['status'] = $status;
    return view('page.admin_product', $data);
  }

  public function getProductData()
  {
    $data['query'] = Product::leftJoin('product__category', 'product__category.category_id', '=', 'product__varian.category_id')
                            ->get(['category_name', 'varian_id', 'varian_name', 'price', 'qty', 'picture', 'weight', 'product__varian.description']);
    
      return Datatables::of($data['query'])
      //->addColumn('actions', '<button id="a">a</button> <br> <button>b</button>')
      ->make(true);
  }
}

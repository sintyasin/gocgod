function show_profile(id,nextid)
{
  var ele=document.getElementById(id).getElementsByTagName("input");
  var error=0;
  for(var i=0;i<ele.length;i++)
  {
    if(ele[i].type=="text" && ele[i].value=="")
  {
    error++;
  }
  }
	
  if(error==0)
  {
    document.getElementById("profile").style.display="none";
    document.getElementById("balance").style.display="none";
    $("#"+nextid).fadeIn();
  }
}

function show_balance(previd,bar)
{
  document.getElementById("checkout_method").style.display="none";
  document.getElementById("subcriber").style.display="none";
  document.getElementById("product_details").style.display="none";
  document.getElementById("delivery_address").style.display="none";
  document.getElementById("choose_agent").style.display="none";
  document.getElementById("payment").style.display="none";
  $("#"+previd).fadeIn();
  document.getElementById(bar).style.backgroundColor="#D8D8D8";
}
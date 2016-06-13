function show_next(id,nextid,bar)
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
    document.getElementById("product_details").style.display="none";
    document.getElementById("delivery_address").style.display="none";
    $("#"+nextid).fadeIn();
    document.getElementById(bar).style.backgroundColor="#38610B";
  }
  else
  {
    alert("Fill All The details");
  }
}

function show_prev(previd,bar)
{
  document.getElementById("product_details").style.display="none";
  document.getElementById("delivery_address").style.display="none";
  $("#"+previd).fadeIn();
  document.getElementById(bar).style.backgroundColor="#D8D8D8";
}
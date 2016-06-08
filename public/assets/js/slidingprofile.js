function show_balance(id)
{
    document.getElementById("profile").style.display="none";
    document.getElementById("balance").style.display="none";
    $("#"+id).fadeIn();
}
function comment_edit(comment_id){
  var tohide = "comment_default_display"+comment_id;
  var toshow = "comment_update_display"+comment_id; 

  if(document.getElementById(tohide).style.display == "none"){
    document.getElementById(tohide).style.display = "block";
    document.getElementById(toshow).style.display = "none";
    
  }else {
    document.getElementById(tohide).style.display = "none";
    document.getElementById(toshow).style.display = "block";
  }
}
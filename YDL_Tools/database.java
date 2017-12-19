<script type="text/javascript" >

function toggle_it(itemID){
  // Toggle visibility between none and inline
  if ((document.getElementById(itemID).style.display == 'none'))
  {
	document.getElementById(itemID).style.display = 'inline';
  } else {
	document.getElementById(itemID).style.display = 'none';
  }
}

function applyCascadingDropdown(sourceId, targetId) {
    var source = document.getElementById(sourceId);
    var target = document.getElementById(targetId);
    if (source && target) {
        source.onchange = function() {
            displayOptionItemsByClass(target, source.value);
        }
        displayOptionItemsByClass(target, source.value);
    }
}

//Displays a subset of a dropdown's options
function displayOptionItemsByClass(selectElement, className) {
    if (!selectElement.backup) {
        selectElement.backup = selectElement.cloneNode(true);
    }
    var options = selectElement.getElementsByTagName("option");
    for(var i=0, length=options.length; i<length; i++) {
        selectElement.removeChild(options[0]);
    }
    var options = selectElement.backup.getElementsByTagName("option");
    for(var i=0, length=options.length; i<length; i++) {
        if (options[i].className==className)
            selectElement.appendChild(options[i].cloneNode(true));
    }
}

//Binds dropdowns
function applyCascadingDropdowns() {
    applyCascadingDropdown("categories1", "items1");
    applyCascadingDropdown("categories2", "items2");
    applyCascadingDropdown("categories3", "items3");
	
    applyCascadingDropdown("frameNum_id", "stopstart_id");
	
    //We could even bind items to another dropdown
    //applyCascadingDropdown("items", "foo");
}

//execute when the page is ready
window.onload=applyCascadingDropdowns;
//Applies cascading behavior for the specified dropdowns



$(document).ready(function(){
  $("#navmenu-h li,#navmenu-v li").hover(
    function() { $(this).addClass("iehover"); },
    function() { $(this).removeClass("iehover"); }
  );
});

/*
Clear default form value script- by JavaScriptKit.com
Featured on JavaScript Kit (http://javascriptkit.com)
Visit javascriptkit.com for 400+ free scripts!
*/

function clearText(thefield){
if (thefield.defaultValue==thefield.value)
thefield.value = ""
} 

</script>




class JlWebManager{
    
    static includeHTML(){ //Gotten by w3schools
        var z, i, elmnt, file, xhttp;
        /* Loop through a collection of all HTML elements: */
        z = document.getElementsByTagName("*");
        for (i = 0; i < z.length; i++) {
            elmnt = z[i];
            /*search for elements with a certain atrribute:*/
            file = elmnt.getAttribute("jlInclude");
            if (file) {
            /* Make an HTTP request using the attribute value as the file name: */
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4) {
                if (this.status == 200) {
                    elmnt.innerHTML = this.responseText.replaceAll('id="', 'id="'+elmnt.id);
                }
                if (this.status == 404) {elmnt.innerHTML = "Page not found.";}
                /* Remove the attribute, and call this function once more: */
                elmnt.removeAttribute("jlInclude");
                JlWebManager.includeHTML();
                JlWebManager.onHTML_Included();
                }
            }
            xhttp.open("GET", file, true);
            xhttp.send();
            /* Exit the function: */
            return;
    }
  }
    }

    static onHTML_Included(){}

    static findViewById(id){
        var tag=document.getElementById(id).tagName.toLowerCase();
        tag=tag[0].toUpperCase()+tag.substring(1);
        return eval('new '+tag+'("'+id+'");');
    }
}
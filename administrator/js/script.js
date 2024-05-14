function searchBooks() {
    var search = document.getElementById('search');
    var container = document.getElementById('container');
    
    search.addEventListener('keyup', function() {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if(xhr.readyState == 4 && xhr.status == 200) {
                container.innerHTML = xhr.responseText;
            }
        }
    
        xhr.open('GET', 'ajax/search-book.php?search=' + search.value, true);
        xhr.send();
    });
}
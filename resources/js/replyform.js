

function addTags(tag_start,tag_end){
    var textarea = document.getElementById('textarea');

    var selectedText = textarea.value.substring(textarea.selectionStart, textarea.selectionEnd);


    if (selectedText !== "") {

        var quotedText = tag_start + selectedText + tag_end;

        textarea.setRangeText(quotedText);
    } else {

        textarea.value += tag_start + tag_end;
    }
}
var code = document.getElementById('code-btn');
code.addEventListener('click', function() {
    addTags("<code>", "</code>");
});
var strong = document.getElementById('bold-btn');
strong.addEventListener('click', function() {
    addTags("<strong>", "</strong>");
});
var italic = document.getElementById('italic-btn');
italic.addEventListener('click', function() {
    addTags("<i>", "</i>");
});
var link = document.getElementById('link-btn');
link.addEventListener('click', function() {
    addTags('<a href="" title="">', "</a>");
});


var form_modal = document.querySelector('#form-modal > form');

// Получаем action формы
var action = form_modal.getAttribute('action');

var replybtns = document.querySelectorAll('#replybtn');

// Добавляем обработчик событий к каждой кнопке
for (var i = 0; i < replybtns.length; i++) {
    replybtns[i].addEventListener('click', set_modal);
}


function set_modal(event) {
    // Получаем элемент, вызвавший событие (в данном случае, кнопку)
    var button = event.target;

    var reply_id = button.getAttribute('data-reply');
    form_modal.setAttribute('action',action+"/"+reply_id)


}

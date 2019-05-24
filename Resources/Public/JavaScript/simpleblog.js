const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
$(document).ready(function () {
    $('#comment-submit').click(function (e) {
        e.preventDefault();
        var form = $('form#comments');

        $.post(ajaxUrl, form.serialize(), function (response) {
            var items = [];

            $.each(response, function (key, item) {
                var date = new Date(item.commentdate);
                var commentdate = date.getDate() + '/' + monthNames[date.getMonth()] + '/' + date.getFullYear();
                items.push(
                    '<li class="list-group-item">' + item.comment
                    + ' <span class="text-muted">(' + commentdate + ')</span>'
                    + '</li>'
                );
            });
            $('#comment-list').html(items.reverse().join(''));
            $('#comment-input').val('');
        });
        return false;
    });
});

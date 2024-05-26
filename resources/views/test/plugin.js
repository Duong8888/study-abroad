$(document).ready(function () {
    $.extend($.summernote.plugins, {
        'tocButton': function (context) {
            var ui = $.summernote.ui;
            var $note = context.layoutInfo.note;
            var $editor = context.layoutInfo.editor;
            var $editable = context.layoutInfo.editable;
            var $toolbar = context.layoutInfo.toolbar;

            // Tạo nút
            var button = ui.button({
                contents: '<i class="fa fa-list-alt"/> TOC',
                tooltip: 'Tạo Mục Lục',
                click: function () {
                    // Gọi hàm để tạo mục lục
                    generateTableOfContents();
                }
            });

            // Thêm nút vào toolbar
            $toolbar.append(button.render());

            function generateTableOfContents() {
                var toc = "<ul>";

                $editable.find('h1, h2, h3, h4, h5, h6').each(function () {
                    var id = $(this).attr('id') || $(this).text().replace(/\s+/g, '-').toLowerCase();
                    $(this).attr('id', id); // Đảm bảo mỗi tiêu đề có một id duy nhất
                    var tag = $(this).prop("tagName").toLowerCase();
                    toc += "<li class='" + tag + "'><a href='#" + id + "'>" + $(this).text() + "</a></li>";
                });

                toc += "</ul>";

                // Chèn mục lục vào vị trí hiện tại của con trỏ
                context.invoke('editor.pasteHTML', toc);
            }
        }
    });
});

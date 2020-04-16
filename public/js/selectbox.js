var $children = $('.children'); //大会サブカテゴリの要素を変数に入れます。
var original = $children.html(); //後のイベントで、不要なoption要素を削除するため、オリジナルをとっておく

//大会側のselect要素が変更になるとイベントが発生
$('.parent').change(function () {

    //選択された大会のvalueを取得し変数に入れる
    var val1 = $(this).val();

    //削除された要素をもとに戻すため.html(original)を入れておく
    $children.html(original).find('option').each(function () {
        var val2 = $(this).data('val'); //data-valの値を取得

        //valueと異なるdata-valを持つ要素を削除
        if (val1 != val2) {
            $(this).not(':first-child').remove();
        }

    });

    //大会側のselect要素が未選択の場合、大会サブカテゴリをdisabledにする
    if ($(this).val() == "") {
        $children.attr('disabled', 'disabled');
    } else {
        $children.removeAttr('disabled');
    }

});

// 予約投稿欄の表示を切り替える
// $('#reserve').click(function() {
//     //クリックイベントで要素をトグルさせる
//     $("#reserve_inputs").slideToggle(this.checked);
// });
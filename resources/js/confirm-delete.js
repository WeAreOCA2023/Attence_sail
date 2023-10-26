document.querySelector('#deleteBtn1').addEventListener('click', function () {
    // 削除ボタンがクリックされたときにConfirmDeleteイベントをトリガー
    const event = new Event('ConfirmDelete');
    document.dispatchEvent(event);
});

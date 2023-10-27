// department-management
document.querySelector('#deleteBtn1').addEventListener('click', function () {
    // 削除ボタンがクリックされたときにConfirmDeleteイベントをトリガー
    const myModal = document.getElementById('myModal')
    const myInput = document.getElementById('myInput')

    myModal.addEventListener('shown.bs.modal', () => {
        myInput.focus()
    })
});
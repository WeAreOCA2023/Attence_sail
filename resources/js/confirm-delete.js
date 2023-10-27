// department-management
// document.querySelector('#deleteBtn1').addEventListener('click', function () {
    // 削除ボタンがクリックされたときにConfirmDeleteイベントをトリガー
//     const myModal = document.getElementById('myModal')
//     const myInput = document.getElementById('myInput')

//     myModal.addEventListener('shown.bs.modal', () => {
//         myInput.focus()
//     })
// });

// $('.deleteBtn').click(function () {
//     var modalId = $(this).attr('data-bs-target'); // data-bs-target属性の値を取得
//     var recordId = modalId.replace('#confirmDeleteModal', ''); 
//     const modalContainer = document.getElementById('modalContainer');
//     console.log(modalContainer);


//     // modalIdをコンソールに出力して確認
//     console.log('modalId: ' + modalId);
//     console.log('recordId: ' + recordId);
//     // モーダルのIDを取得
//     // var modalId = $(this).data('data-bs-target'); 
//     // 部署のIDを取得
//     // var recordId = modalId.replace('#confirmDeleteModal', ''); 
  
//     // モーダル内の削除ボタンがクリックされたときの処理を設定
//     // $('#deleteButton').click(function() {
//       // departmentIdを使用して削除のロジックを実行
//       // ここで削除の実際のロジックを実行
//       // 削除が成功した場合、必要に応じてページの再読み込みなどの処理を実行
//     // });
  
//     // モーダルを表示
//     // $(modalId).modal('show');
    
//     // モーダルを動的に生成
//     modalContainer.innerHtml = `
//         <div class="modal fade" id="${modalId}" tabindex="-1" aria-labelledby="exampleModalLabel">
//             <div class="modal-dialog modal-dialog-centered">
//                 <div class="modal-content">
//                     <div class="modal-header">
//                         <h5 class="modal-title" id="exampleModalLabel">本当に削除しますか？</h5>
//                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
//                     </div>
//                     <div class="modal-body">
//                         <p>「部署名」を削除すると、元には戻せません</p>
//                     </div>
//                     <div class="modal-footer">
//                         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
//                         <button type="button" class="btn btn-primary">削除</button>
//                     </div>
//                 </div>
//             </div>
//         </div>
//     `;
//     console.log(modalContainer.innerHtml);

//     // console.log(modalContainer.innerHtml);

//     // モーダルをコンテナに追加
//     // $('#modalContainer').html(modalHtml);

//     // モーダルを表示
//     // $(modalId).modal('show');
//   });

document.getElementByClass('deleteBtn').addEventListener('click', function() {
    modalId = document.getElementById('data-bs-target');
    insertTo = document.getElementById('modalContainer');

    console.log('hello');

    console.log(insertTo);

    insertTo.innerHtml = `
        <div class="modal fade" id="${modalId}" tabindex="-1" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">本当に削除しますか？</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>「部署名」を削除すると、元には戻せません</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                        <button type="button" class="btn btn-primary">削除</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    console.log(modalContainer.innerHtml);
});
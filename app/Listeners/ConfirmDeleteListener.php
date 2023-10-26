<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ConfirmDeleteListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
       dd('yo');

        
        // $javascript = <<<JS
        //     <script>
        //         var myModal = new bootstrap.Modal(document.querySelector('.modal'));
        //         myModal.show();
        //     </script>
        // JS;

        // echo $javascript;
        
        // <div class="modal-dialog modal-dialog-centered">
        //     <div class="modal" tabindex="-1">
        //         <div class="modal-dialog">
        //             <div class="modal-content">
        //                 <div class="modal-header">
        //                     <h5 class="modal-title">本当に削除しますか？</h5>
        //                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        //                 </div>
        //                 <div class="modal-body">
        //                     <p>一度削除をすると元には戻せません。</p>
        //                 </div>
        //                 <div class="modal-footer">
        //                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
        //                     <button type="button" class="btn btn-primary">削除</button>
        //                 </div>
        //             </div>
        //         </div>
        //     </div>           
        // </div>

    }
}

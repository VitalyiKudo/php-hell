@section('open_chat')
    <div class="open-chat-icon">
        <i class="fa fa-comments fa-3x" aria-hidden="true" id="open-chat-modal-window"></i>
    </div>

    {{-- Modal Window --}}
    <div id="modal-chat" class="modal fade"  tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content modal-content-container" id="modal-content">
                {{-- Here will be mounted Vue App --}}
            </div>
        </div>
    </div>
    
@push('scripts')
<script>
    $(document).ready(function(){
        let loaded = false;

        function showSpinner() {
            $('#modal-content').append(
                $('<div/>', {
                    id : 'chat-app-spinner',
                    class: 'chat-app-info'
                }).append(
                    $('<div/>', {
                        class: 'spinner-border spinner-border-l'
                    })
                )
            );
        }

        function removeSpinner() {
            $('#chat-app-spinner').length !== 0 && $('#chat-app-spinner').remove();
        }
        
        $('#open-chat-modal-window').on('click', function(){
            $('#modal-chat').modal('toggle');
            $('.modal-backdrop').removeClass("modal-backdrop");

            if ($('#chat-app').length === 0) {
            
                showSpinner();
                $('#modal-content').append(
                        $('<div/>', {
                            id : 'chat-app',
                        }).append(
                            $('<chats/>')
                        )
                );

                if (!loaded) {
                    $.getScript('{{ (strtoupper(getenv('APP_ENV')) === 'LOCAL') ? asset('js/chatApp.js')  : mix('js/chatApp.min.js') }}')
                        .done(function() {
                            loaded = true;
                        }).fail(function( jqxhr, settings, exception ) {
                            $('#chat-app').remove();

                            $('#modal-content').append(
                                $('<div/>', {
                                    id : 'chat-app-error',
                                    class: 'chat-app-info'
                                }).text('Something went wrong! Try to reload this page.')
                            );
                        }).always(function() {
                            removeSpinner();
                        });
                }
            }
        });

        $('#modal-chat').on('hidden.bs.modal', function () {
            $('#chat-app-error').length !== 0 && $('#chat-app-error').remove();
            removeSpinner();
        });
    });
</script>
@endpush


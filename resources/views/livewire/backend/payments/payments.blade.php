<div>
    <livewire:backend.payments.payments-table />
    
    <script>
        window.addEventListener('makeAction', event => {

            window["iziToast"][event.detail.type]({
                    title: `${event.detail.title}`,
                    message: `${event.detail.msg}`,
                    position: 'topLeft',
                    rtl: true,
            });

            $(`#${event.detail.id}`).modal('hide');
        })
    </script>
</div>

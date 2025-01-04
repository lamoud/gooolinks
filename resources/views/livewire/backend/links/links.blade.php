<div>
    <livewire:backend.links.links-table />
    <div class="modal fade" id="modal-newlink" tabindex="-1" aria-labelledby="modal-newlinkLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-newlinkLabel">{{ __('Add a link') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Name Field -->
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Owner\'s name') }}</label>
                        <input class="form-control" type="text" name="name" wire:model="name" required autofocus autocomplete="name">
                        @error('name')
                            <small class="invalid-feedback d-block">{{ $message }}</small>
                        @enderror
                    </div>
    
                    <!-- Email Field -->
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input class="form-control" type="email" name="email" wire:model="email" required autofocus autocomplete="username">
                        @error('email')
                            <small class="invalid-feedback d-block">{{ $message }}</small>
                        @enderror
                    </div>
    
                    <!-- Password Field -->
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <div class="input-group input-group-flat">
                            <input type="password" id="pass" class="form-control" name="password" wire:model="password" required autocomplete="new-password">
                            <span class="input-group-text">
                                <a id="pass_icon" href="javascript:void(0)" onclick="show_hide_pass('pass')" class="link-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path>
                                    </svg>
                                </a>
                            </span>
                        </div>
                        @error('password')
                            <small class="invalid-feedback d-block">{{ $message }}</small>
                        @enderror
                    </div>
    
                    <!-- Link Field -->
                    <div class="mb-3">
                        @php
                            $url = url('/');
                            $parsedUrl = parse_url($url);
                            $domain = $parsedUrl['host'];
                        @endphp
                        <label for="link" class="form-label">{{ __('Link') }}</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-link" style="direction: ltr">.{{ $domain }}</span>
                            <input type="text" class="form-control" name="link" wire:model="link" placeholder="link" aria-label="link" aria-describedby="basic-link">
                        </div>
                        @error('link')
                            <small class="invalid-feedback d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-primary" wire:click="saveLink">{{ __('Save') }}</button>
                </div>
            </div>
        </div>
    </div>
    
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
        window.addEventListener('makeRedirect', event => {

            window["iziToast"][event.detail.type]({
                    title: `${event.detail.title}`,
                    message: `${event.detail.msg}`,
                    position: 'topLeft',
                    rtl: true,
            });

            setTimeout(() => {
                window.open(event.detail.url, '_blank');
            }, 2000);

            
        })
        
        window.addEventListener('deleteLink', event => {

            window["iziToast"][event.detail.type]({
                message: `${event.detail.msg}`,
                rtl: true,
                timeout: 20000,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999999999,
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {

                        @this.delete_link(event.detail.id)
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }],
                ]
            });

        })

        window.addEventListener('manageLink', event => {


            @this.generateMagicLink(event.detail.id)


        })
    </script>
</div>

<div>
        <h2>{{ __('Browser Sessions') }}</h2>
            <p>{{ __('Manage and log out your active sessions on other browsers and devices.') }}</p>

            <p class="text-muted">
                {{ __('If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.') }}
            </p>

            @if (count($this->sessions) > 0)
                <ul class="list-group mt-4">
                    @foreach ($this->sessions as $session)
                        <li class="list-group-item d-flex align-items-center">
                            <div>
                                @if ($session->agent->isDesktop())
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-500" style="width: 40px;height:40px">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"></path>
                                </svg>
                                @else
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="40"  height="40"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-mobile"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 5a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-14z" /><path d="M11 4h2" /><path d="M12 17v.01" /></svg>
                                @endif
                            </div>

                            <div class="ms-3">
                                <div class="text-muted">
                                    {{ $session->agent->platform() ? $session->agent->platform() : __('Unknown') }} - {{ $session->agent->browser() ? $session->agent->browser() : __('Unknown') }}
                                </div>

                                <div>
                                    <small class="text-muted">
                                        {{ $session->ip_address }},
                                        @if ($session->is_current_device)
                                            <span class="text-success fw-bold">{{ __('This device') }}</span>
                                        @else
                                            {{ __('Last active') }} {{ $session->last_active }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif

            <div class="d-flex align-items-center mt-4">
                <button class="btn btn-primary" wire:click="confirmLogout" wire:loading.attr="disabled">
                    {{ __('Log Out Other Browser Sessions') }}
                </button>

                <span class="ms-3 text-success" wire:loading wire:target="logoutOtherBrowserSessions">{{ __('Done.') }}</span>
            </div>

    <!-- Log Out Other Devices Confirmation Modal -->
    <div x-data="{ showModal: @entangle('confirmingLogout') }" x-init="
        $watch('showModal', value => {
            let modalElement = document.getElementById('logoutModal');
            {{-- let modal = new bootstrap.Modal(modalElement); --}}
            
            if (value) {
                $('#logoutModal').modal('show');
            } else {
                $('#logoutModal').modal('hide');

            }

            modalElement.addEventListener('hidden.bs.modal', () => {
                if (showModal) {
                    showModal = false;
                    @this.set('confirmingLogout', false);
                }
            });
        });
    " wire:ignore.self class="modal fade" id="logoutModal" tabindex="-1" aria-label="Close" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">{{ __('Log Out Other Browser Sessions') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ __('Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.') }}

                    <div class="mt-3">
                        <input type="password" class="form-control"
                               autocomplete="current-password"
                               placeholder="{{ __('Password') }}"
                               wire:model="password"
                               wire:keydown.enter="logoutOtherBrowserSessions" />
                        @error('password') 
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-primary ms-3" wire:click="logoutOtherBrowserSessions" wire:loading.attr="disabled">
                        {{ __('Log Out Other Browser Sessions') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

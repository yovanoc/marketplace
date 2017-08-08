@component('files.partials._file', compact('file'))
    @slot('links')
        <div class="level">
            <div class="level-left">
                <p class="level-item">
                    {{ $file->isFree() ? 'Free' : $file->price . '€'}}
                </p>
                @if (!$file->approved)
                    <p class="level-item">Pending approval</p>
                @endif
                <p class="level-item">
                    {{ $file->live ? 'Live' : 'Not live'}}
                </p>
                <a href="{{ route('account.files.edit', $file) }}" class="level-item">Make changes</a>
            </div>
        </div>
    @endslot
@endcomponent

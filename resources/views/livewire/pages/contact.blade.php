<div>
    {{-- Header --}}
    <section class="mx-auto max-w-5xl px-5 pt-16 sm:px-8 sm:pt-24">
        <x-eyebrow class="mb-6">{{ __('contact.eyebrow') }}</x-eyebrow>
        <h1 class="max-w-3xl font-mono text-3xl font-bold leading-[1.12] tracking-tight text-ink sm:text-5xl">
            {{ __('contact.heading') }}
        </h1>
        <p class="mt-6 max-w-xl text-lg leading-relaxed text-ink-soft">
            {{ __('contact.intro') }}
        </p>
    </section>

    <section class="mx-auto max-w-5xl px-5 py-14 sm:px-8">
        <div class="grid gap-12 md:grid-cols-[1.5fr_1fr]">
            {{-- Form / success --}}
            <div>
                @if ($sent)
                    <div class="border border-ink bg-card p-8 shadow-[6px_6px_0_0_var(--color-ink)]" role="status" aria-live="polite">
                        <div class="mb-5"><x-stamp status="Live" rotate="-4deg" /></div>
                        <h2 class="font-mono text-2xl font-bold text-ink">{{ __('contact.success_heading') }}</h2>
                        <p class="mt-3 leading-relaxed text-ink-soft">
                            {{ __('contact.success_body') }}
                        </p>
                        <button
                            type="button"
                            wire:click="$set('sent', false)"
                            class="mt-6 font-mono text-sm text-teal hover:text-amber-deep"
                        >
                            {{ __('contact.send_another') }}
                        </button>
                    </div>
                @else
                    <form wire:submit="submit" class="space-y-6" novalidate>
                        {{-- Honeypot: hidden from people, tempting to bots --}}
                        <div aria-hidden="true" class="absolute left-[-9999px] h-px w-px overflow-hidden" tabindex="-1">
                            <label>
                                {{ __('contact.honeypot') }}
                                <input type="text" wire:model="website" tabindex="-1" autocomplete="off">
                            </label>
                        </div>

                        <div class="grid gap-6 sm:grid-cols-2">
                            <div>
                                <label for="name" class="mb-2 block font-mono text-xs uppercase tracking-[0.15em] text-ink-soft">{{ __('contact.name') }}</label>
                                <input
                                    id="name" type="text" wire:model="name" autocomplete="name"
                                    class="w-full border border-ink bg-paper px-4 py-3 font-mono text-sm text-ink placeholder:text-ink-soft/50 focus:border-amber focus:bg-card focus:outline-none"
                                    placeholder="{{ __('contact.name_ph') }}"
                                >
                                @error('name') <p class="mt-1.5 font-mono text-xs text-rust">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="email" class="mb-2 block font-mono text-xs uppercase tracking-[0.15em] text-ink-soft">{{ __('contact.email') }}</label>
                                <input
                                    id="email" type="email" wire:model="email" autocomplete="email"
                                    class="w-full border border-ink bg-paper px-4 py-3 font-mono text-sm text-ink placeholder:text-ink-soft/50 focus:border-amber focus:bg-card focus:outline-none"
                                    placeholder="{{ __('contact.email_ph') }}"
                                >
                                @error('email') <p class="mt-1.5 font-mono text-xs text-rust">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="subject" class="mb-2 block font-mono text-xs uppercase tracking-[0.15em] text-ink-soft">{{ __('contact.subject') }} <span class="normal-case text-ink-soft/60">{{ __('contact.optional') }}</span></label>
                            <input
                                id="subject" type="text" wire:model="subject"
                                class="w-full border border-ink bg-paper px-4 py-3 font-mono text-sm text-ink placeholder:text-ink-soft/50 focus:border-amber focus:bg-card focus:outline-none"
                                placeholder="{{ __('contact.subject_ph') }}"
                            >
                            @error('subject') <p class="mt-1.5 font-mono text-xs text-rust">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="message" class="mb-2 block font-mono text-xs uppercase tracking-[0.15em] text-ink-soft">{{ __('contact.message') }}</label>
                            <textarea
                                id="message" wire:model="message" rows="6"
                                class="w-full resize-y border border-ink bg-paper px-4 py-3 font-mono text-sm leading-relaxed text-ink placeholder:text-ink-soft/50 focus:border-amber focus:bg-card focus:outline-none"
                                placeholder="{{ __('contact.message_ph') }}"
                            ></textarea>
                            @error('message') <p class="mt-1.5 font-mono text-xs text-rust">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <x-btn type="submit" variant="primary" size="lg" wire:loading.attr="disabled" wire:target="submit">
                                <span wire:loading.remove wire:target="submit">{{ __('contact.send') }}</span>
                                <span wire:loading wire:target="submit">{{ __('contact.sending') }}<span class="caret"></span></span>
                            </x-btn>
                            <span class="font-mono text-xs text-ink-soft">{{ __('contact.assurance') }}</span>
                        </div>
                    </form>
                @endif
            </div>

            {{-- What to expect --}}
            <aside class="space-y-8">
                <div>
                    <h2 class="mb-4 font-mono text-xs uppercase tracking-[0.2em] text-amber-deep">{{ __('contact.prefer_email') }}</h2>
                    <a href="mailto:odinwolfperica@gmail.com" class="font-mono text-sm text-ink underline decoration-line underline-offset-4 hover:decoration-amber">
                        odinwolfperica@gmail.com
                    </a>
                </div>

                <div>
                    <h2 class="mb-4 font-mono text-xs uppercase tracking-[0.2em] text-amber-deep">{{ __('contact.what_next') }}</h2>
                    <ol class="space-y-3 font-mono text-sm text-ink-soft">
                        @foreach (__('contact.next') as $i => $line)
                            <li class="flex gap-3"><span class="text-teal">0{{ $i + 1 }}</span> {{ $line }}</li>
                        @endforeach
                    </ol>
                </div>

                <div class="border border-line bg-card p-5">
                    <p class="font-mono text-xs leading-relaxed text-ink-soft">
                        {{ __('contact.availability_pre') }} <span class="text-ink">{{ __('contact.availability_strong') }}</span> {{ __('contact.availability_post') }}
                    </p>
                </div>
            </aside>
        </div>
    </section>
</div>

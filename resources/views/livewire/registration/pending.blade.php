<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    //
}; ?>

<div class="flex flex-col gap-6 text-center">
    {{-- 💡 تعديل النصوص إلى العربية --}}
    <x-auth-header :title="__('الحساب قيد المراجعة')" :description="__('تم إنشاء حسابك بنجاح وهو الآن قيد المراجعة من قبل الإدارة. سيتم إعلامك بمجرد تفعيل حسابك.')" />

    <p class="text-zinc-600 dark:text-zinc-400">
        {{ __('شكرًا لتسجيلك. يرجى الانتظار حتى يقوم المسؤول بتفعيل حسابك.') }}
    </p>

    <div class="mt-4">
        <a href="{{ route('login') }}" class="text-sky-600 hover:text-sky-800 font-semibold" wire:navigate>
            {{ __('العودة إلى صفحة تسجيل الدخول') }}
        </a>
    </div>
</div>

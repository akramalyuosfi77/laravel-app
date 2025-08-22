<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ConfirmDeleteModal extends Component
{
    public string $action;
    public string $state;
    public string $title;
    public string $message;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $action,
        string $state,
        string $title = 'تأكيد الحذف',
        string $message = 'هل أنت متأكد من رغبتك في حذف هذا العنصر؟ لا يمكن التراجع عن هذا الإجراء.'
    ) {
        $this->action = $action;
        $this->state = $state;
        $this->title = $title;
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.confirm-delete-modal');
    }
}

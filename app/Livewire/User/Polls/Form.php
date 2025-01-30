<?php

namespace App\Livewire\User\Polls;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Form extends Component
{
    public Collection $languages;
    public array $poll;
    public string $variant;

    public function mount(string $variant, Collection $languages, array $poll = [])
    {
        $this->variant = $variant;
        $this->languages = $languages;
        $this->poll = $poll;

        if (empty($this->poll)) {
            $this->addTranslation(true);
        }
    }

    public function addTranslation($isDefault = false)
    {
        $languagesInUse = collect($this->poll)->pluck('language')->toArray();

        $this->poll[] = [
            'question' => [
                'id' => null,
                'value' => ''
            ],
            'options' => [
                [
                    'id' => null,
                    'value' => ''
                ],
                [
                    'id' => null,
                    'value' => ''
                ]
            ],
            'language' => $this->languages->whereNotIn('id', $languagesInUse)->first()?->id,
            'is_default' => $isDefault
        ];
    }

    public function removeTranslation($index)
    {
        unset($this->poll[$index]);
        $this->poll = array_values($this->poll);
        $this->render();
    }

    public function render()
    {
        return view('livewire.user.polls.form');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;

class PageAbout extends Component
{
    public array $slides = [];
    public int $active = 0;

    public function mount()
    {
        $this->slides = [
            [
                'title' => 'Визитка',
                'image' => asset('images/about.png'),
            ],
            [
                'title' => 'Визитка',
                'image' => asset('images/about.png'),
            ],
        ];
    }

    public function setSlide($index)
    {
        $count = count($this->slides);
        $this->active = ($index + $count) % $count;
    }

    public function next()
    {
        $this->setSlide($this->active + 1);
    }

    public function prev()
    {
        $this->setSlide($this->active - 1);
    }

    public function render()
    {
        return view('livewire.page-about');
    }
}

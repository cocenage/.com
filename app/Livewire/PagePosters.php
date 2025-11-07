<?php

namespace App\Livewire;

use Livewire\Component;

class PagePosters extends Component
{
    public array $slides = [];
    public int $active = 0;

    public function mount()
    {
        $this->slides = [
            [
                'title' => 'Постер 1',
                'image' => asset('images/poster.png'),
            ],
            [
                'title' => 'Постер 2',
                'image' => asset('images/poster.png'),
            ],
            [
                'title' => 'Постер 3',
                'image' => asset('images/poster.png'),
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
        return view('livewire.page-posters');
    }
}

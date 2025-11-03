<?php

namespace App\Livewire;

use Livewire\Component;

class PageHome extends Component
{
    public array $slides = [];
    public int $active = 0;

    public function mount()
    {
        // сюда подставь свои данные / из БД
        $this->slides = [
            [
                'title' => 'Сайты',
                'image' => asset('images/test.png'),
                'url' => route('page.sites'),
            ],
            [
                'title' => 'Постеры',
                'image' => asset('images/test2.jpg'),
                'url' => route('page.posters'),
            ],
            [
                'title' => 'Про меня',
                'image' => asset('images/test3.jpg'),
                'url' => route('page.about'),
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
        return view('livewire.page-home');
    }
}

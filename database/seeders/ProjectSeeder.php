<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

final class ProjectSeeder extends Seeder
{
    /**
     * Seed the portfolio's case studies.
     *
     * Real, shipped client work leads the list; a couple of sample builds round
     * out the grid. To add a project, append an entry below — the upsert is keyed
     * by slug so re-running `db:seed` updates rows in place instead of duplicating.
     * Drop a screenshot in public/images/projects/ and set `cover_image` to its
     * filename to give a project a cover.
     */
    public function run(): void
    {
        foreach ($this->projects() as $order => $project) {
            $project['slug'] ??= Str::slug($project['title']);
            $project['sort_order'] = $order;

            Project::updateOrCreate(['slug' => $project['slug']], $project);
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function projects(): array
    {
        return [
            [
                'title' => 'Libra',
                'tagline' => 'A warm, illustration-led website for a Zadar education studio running school-prep workshops for young kids.',
                'role' => 'Design & build',
                'client' => 'Libra, obrt za poduku',
                'year' => '2024',
                'status' => 'Live',
                'is_featured' => true,
                'tech_stack' => ['Laravel', 'Livewire', 'Tailwind'],
                'live_url' => 'https://www.libra-zadar.hr',
                'cover_image' => 'libra.jpg',
                'body' => <<<'MD'
                Libra runs school-prep workshops and learning programmes for young children in Zadar. They needed a website that felt as warm and playful as the classroom, while making it easy for parents to understand the programmes and get in touch.

                I designed and built the site end to end — an illustration-led hero, a clear overview of the workshops on offer, the studio's story and teaching values, and a contact form parents can use to enquire. It's fully responsive and loads fast on a phone, where most parents find it.

                The result is a friendly, professional presence that turns curious parents into enquiries, with a structure the studio can keep extending as new workshops and seasonal programmes are added.
                MD,
            ],
            [
                'title' => 'Judo Klub Bura',
                'tagline' => 'A news, schedule, and results hub for a young Croatian judo club — built to grow with the team.',
                'role' => 'Design & build',
                'client' => 'Judo Klub Bura',
                'year' => '2024',
                'status' => 'Live',
                'is_featured' => true,
                'tech_stack' => ['Laravel', 'Livewire', 'Tailwind'],
                'live_url' => 'https://www.judo-klub-bura.com.hr',
                'cover_image' => 'judo-klub-bura.jpg',
                'body' => <<<'MD'
                Judo Klub Bura is a young judo club on the Croatian coast, founded in 2023 in Ljubač and training everyone from five-year-olds to adults. As the club grew past forty members and started winning medals, it needed an online home that could keep up.

                I designed and built the site as a living hub: the club's story and coaches, a training schedule, competition results, club news, and a photo gallery the club updates itself after every tournament. Everything works on a phone so members and parents can check times and results on the go.

                The site gives the club a credible public face for attracting new members and sponsors, and an easy way to celebrate results and share photos without relying on social media alone.
                MD,
            ],
            [
                'title' => 'Cellar',
                'tagline' => 'Inventory and point-of-sale for an independent wine bar.',
                'role' => 'Design & build',
                'client' => 'Cellar & Co.',
                'year' => '2024',
                'status' => 'Shipped',
                'is_featured' => false,
                'tech_stack' => ['Laravel', 'Livewire', 'Tailwind', 'MySQL'],
                'live_url' => null,
                'body' => <<<'MD'
                A neighbourhood wine bar was tracking three hundred bottles on paper and losing money to bottles that quietly ran out. They needed something staff could learn in one shift.

                I designed and built a touch-first POS with live stock levels, a tasting-note library, and a supplier reorder list that fills itself based on what sells. Everything works on the iPad behind the bar.

                Stocktakes that used to take a full evening now take twenty minutes, and the owner finally trusts the numbers enough to plan the next season's list around them.
                MD,
            ],
            [
                'title' => 'Studioflow',
                'tagline' => 'Booking, contracts, and payments for a photography studio.',
                'role' => 'Solo build',
                'client' => 'Studioflow',
                'year' => '2023',
                'status' => 'Shipped',
                'is_featured' => false,
                'tech_stack' => ['Laravel', 'Livewire', 'Tailwind', 'Stripe'],
                'live_url' => null,
                'body' => <<<'MD'
                A portrait studio was losing hours every week to back-and-forth emails: pick a date, sign a contract, pay a deposit, repeat. The admin was eating into shooting time.

                I built a self-serve booking flow where clients choose a slot, sign the agreement, and pay the deposit in one sitting. Each booking pushes straight to the studio's calendar.

                The studio cut its admin roughly in half and stopped double-booking weekends — the system simply won't let a taken slot be booked twice.
                MD,
            ],
        ];
    }
}

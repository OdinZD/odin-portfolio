<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

final class ProjectSeeder extends Seeder
{
    /**
     * Seed sample case studies.
     *
     * These are placeholders that read like finished client work — replace the
     * copy, links, and cover images with your real projects. Drop screenshots in
     * public/images/projects/ and set `cover_image` to the filename to use them.
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
                'title' => 'Ledger',
                'tagline' => 'Invoicing and cash-flow tracking for freelancers who hate spreadsheets.',
                'role' => 'Solo build',
                'client' => 'Independent product',
                'year' => '2025',
                'status' => 'Live',
                'is_featured' => true,
                'tech_stack' => ['Laravel', 'Livewire', 'Tailwind', 'Stripe', 'Postgres'],
                'live_url' => 'https://example.com/ledger',
                'body' => <<<'MD'
                Freelancers were stitching together spreadsheets, calendar reminders, and bank apps just to answer one question: am I getting paid on time? Ledger replaces all of that with a single dashboard.

                I built the full product end to end — recurring invoices, automated payment reminders, Stripe checkout, and a cash-flow forecast that projects the next ninety days from real payment history.

                Since launch it has processed thousands of invoices with no manual chasing. Late payments dropped because reminders go out on their own, and the forecast gives users a reason to log in every week.
                MD,
            ],
            [
                'title' => 'Cellar',
                'tagline' => 'Inventory and point-of-sale for an independent wine bar.',
                'role' => 'Design & build',
                'client' => 'Cellar & Co.',
                'year' => '2024',
                'status' => 'Shipped',
                'is_featured' => true,
                'tech_stack' => ['Laravel', 'Livewire', 'Tailwind', 'MySQL'],
                'live_url' => 'https://example.com/cellar',
                'body' => <<<'MD'
                A neighbourhood wine bar was tracking three hundred bottles on paper and losing money to bottles that quietly ran out. They needed something staff could learn in one shift.

                I designed and built a touch-first POS with live stock levels, a tasting-note library, and a supplier reorder list that fills itself based on what sells. Everything works on the iPad behind the bar.

                Stocktakes that used to take a full evening now take twenty minutes, and the owner finally trusts the numbers enough to plan the next season's list around them.
                MD,
            ],
            [
                'title' => 'Routeline',
                'tagline' => 'A dispatch board that keeps a same-day courier fleet moving.',
                'role' => 'Lead developer',
                'client' => 'Routeline Logistics',
                'year' => '2025',
                'status' => 'Live',
                'is_featured' => true,
                'tech_stack' => ['Laravel', 'Livewire', 'Tailwind', 'Redis', 'Postgres'],
                'live_url' => 'https://example.com/routeline',
                'body' => <<<'MD'
                A courier company was running dispatch over phone calls and a whiteboard. As they grew past a dozen drivers, jobs started slipping through the cracks.

                I led the build of a real-time dispatch board: drag-and-drop assignment, live driver status, and automatic customer notifications at every step. The board updates instantly across every screen in the office.

                Dispatchers now handle roughly twice the volume per shift, and "where's my delivery?" calls dropped sharply once customers started getting their own updates.
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
                'live_url' => 'https://example.com/studioflow',
                'body' => <<<'MD'
                A portrait studio was losing hours every week to back-and-forth emails: pick a date, sign a contract, pay a deposit, repeat. The admin was eating into shooting time.

                I built a self-serve booking flow where clients choose a slot, sign the agreement, and pay the deposit in one sitting. Each booking pushes straight to the studio's calendar.

                The studio cut its admin roughly in half and stopped double-booking weekends — the system simply won't let a taken slot be booked twice.
                MD,
            ],
            [
                'title' => 'Pulsewatch',
                'tagline' => 'Uptime monitoring and status pages for small engineering teams.',
                'role' => 'Solo build',
                'client' => 'Independent product',
                'year' => '2026',
                'status' => 'Live',
                'is_featured' => false,
                'tech_stack' => ['Laravel', 'Livewire', 'Tailwind', 'Redis', 'Postgres'],
                'live_url' => 'https://example.com/pulsewatch',
                'body' => <<<'MD'
                Small teams wanted to know their site was down before their customers told them — without paying enterprise prices for the privilege.

                Pulsewatch runs checks from multiple regions, escalates alerts through email and chat, and publishes a clean public status page. The whole thing is built on Laravel's queue and scheduler.

                Teams catch outages in minutes instead of waiting for support tickets, and the hosted status page saves them building one of their own.
                MD,
            ],
            [
                'title' => 'Foldercraft',
                'tagline' => 'A document portal that lets agencies hand files to clients without the email chaos.',
                'role' => 'Design & build',
                'client' => 'Foldercraft',
                'year' => '2024',
                'status' => 'Shipped',
                'is_featured' => false,
                'tech_stack' => ['Laravel', 'Livewire', 'Tailwind', 'S3'],
                'live_url' => 'https://example.com/foldercraft',
                'body' => <<<'MD'
                An agency was sending deliverables as zip files over email and losing track of which client had which version. Nobody could ever find the latest one.

                I designed and built a branded client portal: organised folders, versioned files, and a simple approval button so clients can sign off without a meeting. Uploads stream straight to S3.

                Version confusion disappeared, and sign-off that used to take a week of reminders now happens in a couple of clicks.
                MD,
            ],
        ];
    }
}

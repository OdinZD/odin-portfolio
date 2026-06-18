<?php

declare(strict_types=1);

return [
    'title' => 'About',
    'eyebrow' => 'About',
    'heading' => 'A developer who ships — and sticks around afterwards.',
    'hello' => "Hello — I'm Odin.",
    'bio' => [
        "I'm a freelance web developer. For the past several years I've helped founders and small teams turn ideas into working software — the kind people log into every day to run their business.",
        'I work across the whole stack, but my home is <span class="text-ink">Laravel</span> and <span class="text-ink">Livewire</span>. That lets me move fast without leaving a mess behind: clean code, sensible structure, and apps that are still easy to change a year later.',
        'Most of all, I care about <span class="text-ink">shipping</span>. A half-built feature helps nobody. I\'d rather scope tightly, build the thing that matters, get it in front of real users, and improve from there.',
        "When a project launches I don't disappear. I make sure it runs in production and stay on hand to fix, tune, and grow it as your needs change.",
    ],

    'profile_label' => 'Profile',
    'profile' => [
        ['k' => 'Name', 'v' => 'Odin Wolf'],
        ['k' => 'Role', 'v' => 'Web app developer'],
        ['k' => 'Based', 'v' => 'Remote · worldwide'],
        ['k' => 'Focus', 'v' => 'Laravel · Livewire'],
        ['k' => 'Status', 'v' => 'Open to projects'],
    ],
    'get_in_touch' => 'Get in touch →',

    'toolkit_eyebrow' => 'The toolkit',
    'toolkit_heading' => 'What I work with',
    'toolkit' => [
        ['group' => 'Backend', 'items' => ['Laravel', 'PHP', 'MySQL', 'PostgreSQL', 'Redis', 'REST APIs']],
        ['group' => 'Frontend', 'items' => ['Livewire', 'Alpine.js', 'Tailwind CSS', 'Vite', 'JavaScript']],
        ['group' => 'Shipping', 'items' => ['Git', 'Pest', 'CI/CD', 'Docker', 'Forge', 'Cloud hosting']],
    ],

    'principles_eyebrow' => 'How I work',
    'principles_heading' => 'A few things I hold to',
    'principles' => [
        ['title' => 'Ship over polish', 'body' => 'Working software in real hands beats a perfect plan on paper. We launch, then we sharpen.'],
        ['title' => 'No surprises', 'body' => 'Clear scope, honest estimates, and weekly check-ins. You always know where things stand.'],
        ['title' => 'Built to last', 'body' => 'Readable code and tests, so the app is still easy and cheap to change long after launch.'],
        ['title' => 'Your goals first', 'body' => "I'm here to move your business, not to chase the newest framework for its own sake."],
    ],
];

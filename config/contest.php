<?php

return [
    /*
     * Types of Contests  that an be created
     */
    'types'            => [
        ''                => '',
        'art'             => 'Art',
//        'dance'           => 'Dance',
//        'painting'        => 'Painting',
//        'music'           => 'Music',
//        'singing'         => 'Singing',
//        'photography'     => 'Photography',
//        'short films'     => 'Short Films',
        'content writing' => 'Creative Writing',
//        'business idea'   => 'Business Idea'
    ],
    /*
     * Types of files that a user can submit
     */
    'submission_types' => [
        ''     => '',
//        'image'    => 'Photo',
        'text' => 'Text',
//        'document' => 'Document',
//        'video'    => 'Video',
//        'audio'    => 'Audio',
//        'any'      => 'Other',
    ],
    'submission'       => [
        'text'  => App\Entry\TextEntry::class,
    ]
];

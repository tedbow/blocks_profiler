# Drupal 8 Blocks profiler

Drupal console commands to generate thousands of blocks. 

Needed to test:
https://www.drupal.org/project/drupal/issues/2978102

## Usage

Apply patch here: https://www.drupal.org/project/drupal/issues/2976334#comment-12644039

`drupal upd`

`drupal upe`

Enable module

`drupal moi blocks_profiler`

To get a count of blocks use View at `/blocks-count`

Generate 10000 reusable blocks

`drupal bpg reusable 10000`

Try to visit any page on your site as logged in user.
It shouldn't work but if it does try another 10000.

Delete all custom blocks

`drupal bpd`

Generate 20000 non-reusable blocks!

`drupal bpg non-reusable 20000`

Try to visit any page on your site as logged in user.
It should be fine.




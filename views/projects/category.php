<?php /* Project category page — markup per category: views/projects/categories/<slug>.php */
$catFile = view_path('projects/categories/' . basename($category['slug']) . '.php');
if (is_file($catFile)) {
    require $catFile;
} else {
    redirect('/projects');
}

<?php
// Database connection
include 'C:\xampp\htdocs\HiTDA\db_connect.php';

// Query to fetch articles and their views
$query = "
    SELECT a.tags, cv.views
    FROM article a
    JOIN content_views cv ON a.id = cv.article_id
";

$result = $conn->query($query);

$tagsSet = [];
if ($result) {
    while ($article = $result->fetch_assoc()) {
        // Decode the outer JSON array of tags
        $outerTags = json_decode($article['tags'], true);
        if (is_array($outerTags)) {
            foreach ($outerTags as $innerTagJson) {
                // Decode the inner JSON object for each tag
                $innerTags = json_decode($innerTagJson, true);
                if (is_array($innerTags)) {
                    foreach ($innerTags as $tag) {
                        if (isset($tag['value'])) {
                            // Aggregate views for each unique tag
                            $tagValue = $tag['value'];
                            if (!isset($tagsSet[$tagValue])) {
                                $tagsSet[$tagValue] = 0;
                            }
                            $tagsSet[$tagValue] += $article['views'];
                        }
                    }
                }
            }
        }
    }
}

$conn->close();

// Prepare data for JSON response
$data = [];
foreach ($tagsSet as $tag => $views) {
    $data[] = [
        'tag' => $tag,
        'views' => $views
    ];
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>

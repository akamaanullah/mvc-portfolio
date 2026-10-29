<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\VisitorModel;

class AnalyticsController extends Controller
{
    /**
     * POST /api/analytics/event
     * Ultra-fast, lightweight beacon endpoint for real-time frontend user interactions
     * (scroll depth milestones, CTA clicks, WhatsApp taps, dwell time).
     */
    public function recordEvent(): string
    {
        // Basic origin validation to avoid cross-site abuse
        $origin = $_SERVER['HTTP_ORIGIN'] ?? $_SERVER['HTTP_REFERER'] ?? '';
        $host = $_SERVER['HTTP_HOST'] ?? '';
        if ($origin && $host && !str_contains($origin, $host) && !str_contains($origin, 'localhost') && !str_contains($origin, '127.0.0.1')) {
            return $this->json(['success' => false, 'error' => 'Forbidden'], 403);
        }

        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);

        if (!$data && !empty($_POST)) {
            $data = $_POST;
        }

        if (!$data && !empty($_GET)) {
            $data = $_GET;
        }

        if (empty($data)) {
            return $this->json(['success' => false, 'error' => 'No data received']);
        }

        // Support array of events or { events: [...] } for high-efficiency batching
        $events = [];
        if (isset($data['events']) && is_array($data['events'])) {
            $events = $data['events'];
        } elseif (isset($data[0]) && is_array($data[0])) {
            $events = $data;
        } else {
            $events = [$data];
        }

        $recorded = 0;
        foreach ($events as $ev) {
            if (!is_array($ev)) continue;

            $url = trim((string)($ev['url'] ?? $_SERVER['HTTP_REFERER'] ?? '/'));
            $type = trim((string)($ev['type'] ?? $ev['event_type'] ?? ''));
            $name = trim((string)($ev['name'] ?? $ev['event_name'] ?? ''));
            $value = (int)($ev['value'] ?? $ev['event_value'] ?? 0);

            if ($type !== '' && $name !== '') {
                VisitorModel::recordEvent($url, $type, $name, $value);
                $recorded++;
            }
        }

        return $this->json(['success' => true, 'recorded' => $recorded]);
    }
}

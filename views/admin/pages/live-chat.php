<?php
/**
 * Admin · Live Chat — 100% Dynamic Real-Time Chat & Human Takeover Panel.
 */
$conversations = $conversations ?? [];
$active = $activeConversation ?? null;
$messages = $activeMessages ?? [];
$profile = $visitorProfile ?? [];
$needsCount = $needsHumanCount ?? 0;
$currentTab = $currentTab ?? 'active';

function getAvatarInitials(?string $name): string {
    if (empty($name)) return 'V#';
    $parts = explode(' ', trim($name));
    if (count($parts) >= 2) {
        return strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
    }
    return strtoupper(substr($name, 0, 2));
}

function getAvatarColor(?string $name): string {
    $colors = ['', 'b', 'g', 'c', 'p'];
    $idx = abs(crc32($name ?? 'visitor')) % count($colors);
    return $colors[$idx];
}
?>

<div class="ph-h">
    <div>
        <div class="crumbs">Admin / Analytics</div>
        <h1>Live chat <span class="pill good" style="font-size:11px; vertical-align:middle; margin-left:6px;">Live System</span></h1>
        <p>Monitor AI assistant conversations, answer visitors in real-time, and take over any chat.</p>
    </div>
    <div class="acts">
        <span class="live" style="margin-right:6px" id="activeCountBadge"><?= count($conversations) ?> active</span>
        <a class="btn" href="<?= base_url('/admin/settings') ?>">
            <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.8-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 0 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.8.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.8 1.7 1.7 0 0 0-1.5-1H3a2 2 0 0 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.8l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.8.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 0 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.8-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.8V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 0 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z"/></svg> 
            Bot settings
        </a>
    </div>
</div>

<section class="card inbox">
    <!-- Left column: Conversation list & tabs -->
    <div class="ibl">
        <div class="toolbar">
            <label class="isrch" style="max-width:none">
                <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M21 21l-5-5"/></svg>
                <input id="chatSearchInp" placeholder="Search chats by name, email, message…" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
            </label>
        </div>
        <div class="tabs" style="padding:0 8px">
            <a href="<?= base_url('/admin/live-chat?tab=active') ?>" class="tab-link <?= $currentTab === 'active' ? 'on' : '' ?>" style="text-decoration:none; color:inherit;">Active</a>
            <a href="<?= base_url('/admin/live-chat?tab=needs_human') ?>" class="tab-link <?= $currentTab === 'needs_human' ? 'on' : '' ?>" style="text-decoration:none; color:inherit;">
                Needs you <span class="pill bad nd" id="needsYouPill" style="padding:0 6px; display:<?= $needsCount > 0 ? 'inline-block' : 'none' ?>;"><?= $needsCount ?></span>
            </a>
            <a href="<?= base_url('/admin/live-chat?tab=closed') ?>" class="tab-link <?= $currentTab === 'closed' ? 'on' : '' ?>" style="text-decoration:none; color:inherit;">Closed</a>
        </div>
        <div class="lst" id="cvl">
            <?php if (empty($conversations)): ?>
                <div style="padding: 2.5rem 1rem; text-align:center; color: var(--text-muted); font-size: 0.88rem;">
                    <svg class="i" style="width:32px; height:32px; opacity:0.4; margin-bottom:8px;" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    <div>No conversations found in this view.</div>
                </div>
            <?php else: ?>
                <?php foreach ($conversations as $cv): 
                    $isSelected = ($active && $active['id'] === $cv['id']);
                    $init = getAvatarInitials($cv['visitor_name']);
                    $color = getAvatarColor($cv['visitor_name']);
                    $needsYou = ($cv['status'] === 'needs_human');
                ?>
                    <a href="<?= base_url('/admin/live-chat?session=' . urlencode($cv['session_id']) . '&tab=' . urlencode($currentTab)) ?>" 
                       class="cv <?= $isSelected ? 'on' : '' ?>" 
                       data-id="<?= $cv['id'] ?>" 
                       data-session="<?= htmlspecialchars($cv['session_id']) ?>"
                       style="text-decoration:none; color:inherit;">
                        <span class="ava <?= $color ?>"><?= $init ?></span>
                        <div class="who">
                            <b><?= htmlspecialchars($cv['visitor_name'] ?: 'Visitor') ?>
                                <?php if ($needsYou): ?>
                                    <span class="pill bad nd" style="font-size:10px; padding:1px 6px">needs you</span>
                                <?php elseif ($cv['status'] === 'active'): ?>
                                    <span class="pill good" style="font-size:10px; padding:1px 6px">live</span>
                                <?php endif; ?>
                            </b>
                            <p><?= htmlspecialchars($cv['last_message'] ?: 'Conversation active') ?></p>
                        </div>
                        <span class="tm"><?= date('H:i', strtotime($cv['updated_at'])) ?></span>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Middle column: Thread & Message Area -->
    <div class="thr">
        <?php if ($active): ?>
            <div class="th2">
                <span class="ava <?= getAvatarColor($active['visitor_name']) ?>"><?= getAvatarInitials($active['visitor_name']) ?></span>
                <div>
                    <b id="cvName"><?= htmlspecialchars($active['visitor_name'] ?: 'Visitor') ?></b>
                    <?php if (!empty($active['visitor_email'])): ?>
                        <span style="font-size:12px; color:var(--text-muted); margin-left:6px;">(<?= htmlspecialchars($active['visitor_email']) ?>)</span>
                    <?php endif; ?>
                    <br>
                    <small class="mut">
                        <?= htmlspecialchars($active['location'] ?: 'Location detected via IP') ?> · on <?= htmlspecialchars($active['current_page'] ?: '/') ?>
                    </small>
                </div>
                <span style="flex:1"></span>
                <label class="row" style="font-weight:700;font-size:13px; cursor:pointer;">
                    <span id="tkLbl"><?= in_array($active['status'], ['needs_human', 'active']) ? 'Human handling' : 'Bot is handling' ?></span>
                    <span class="sw"><input type="checkbox" id="takeover" <?= in_array($active['status'], ['needs_human', 'active']) ? 'checked' : '' ?>><i></i></span>
                </label>
                <button class="ib" data-info aria-label="Visitor info" title="Toggle Visitor Profile">
                    <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 16v-4M12 8h.01"/></svg>
                </button>
                <button class="btn sm" id="btnCloseChat" title="Close this conversation">Close</button>
            </div>

            <div class="msgs" id="msgs">
                <div class="m sys">Session started · <?= date('M j, H:i', strtotime($active['created_at'])) ?></div>
                <?php if (empty($messages)): ?>
                    <div class="m sys">No messages recorded yet. Waiting for visitor...</div>
                <?php else: ?>
                    <?php foreach ($messages as $m): 
                        if ($m['message'] === '__CLOSED__') {
                            echo '<div class="m sys">Conversation was closed.</div>';
                            continue;
                        }
                        $senderClass = $m['sender'] === 'visitor' ? 'v' : ($m['sender'] === 'admin' ? 'a' : 'b');
                        $senderLabel = $m['sender'] === 'visitor' ? htmlspecialchars($active['visitor_name'] ?: 'Visitor') : ($m['sender'] === 'admin' ? 'Amaanullah (You)' : 'Bot');
                        $timeStr = date('H:i', strtotime($m['created_at']));
                    ?>
                        <div class="m <?= $senderClass ?>" data-mid="<?= $m['id'] ?>">
                            <?= nl2br(htmlspecialchars($m['message'])) ?>
                            <small><?= $senderLabel ?> · <?= $timeStr ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if ($active['status'] === 'needs_human'): ?>
                    <div class="m sys" style="color:#ef4444; font-weight:700;">⚠ Visitor requested a human. Take over or reply below to speak live!</div>
                <?php endif; ?>
            </div>

            <!-- Composer & Canned Quick Replies -->
            <div class="comp">
                <div class="canned">
                    <button type="button" class="canned-btn" data-t="Hi! This is Amaanullah Khan. Thanks for reaching out! How can I help you with your project?">👋 Greeting</button>
                    <button type="button" class="canned-btn" data-t="I would love to discuss this. You can pick a convenient time on my calendar or we can connect on WhatsApp (+92 319 6935307).">📅 Book a call</button>
                    <button type="button" class="canned-btn" data-t="Pricing depends on the scope and timeline. Could you share your core feature requirements and target launch date?">💰 Pricing</button>
                    <button type="button" class="canned-btn" data-t="Could you share your best email and WhatsApp number so I can send over a detailed architecture proposal?">📧 Ask contact</button>
                    <button type="button" class="canned-btn" data-t="Thank you! I will review all your requirements thoroughly and follow up within 24 hours.">⏱ Follow-up</button>
                </div>
                <div class="row">
                    <textarea class="inp" id="cmpTxt" placeholder="Type your reply here... (Press Enter to send, Shift+Enter for new line)" aria-label="Reply"></textarea>
                    <button class="btn o" id="cmpSend" type="button" aria-label="Send">
                        <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4z"/></svg>
                    </button>
                </div>
            </div>
        <?php else: ?>
            <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; height:100%; color:var(--text-muted); text-align:center; padding:2rem;">
                <svg class="i" style="width:48px; height:48px; opacity:0.3; margin-bottom:12px;" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                <h3>No conversation selected</h3>
                <p>Pick a chat from the left panel to review or take over.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Right column: Visitor Profile Sidebar -->
    <?php if ($active): ?>
        <aside class="vinfo" id="vinfoPanel">
            <div class="row" style="margin-bottom:12px">
                <span class="ava <?= getAvatarColor($active['visitor_name']) ?>"><?= getAvatarInitials($active['visitor_name']) ?></span>
                <div>
                    <b id="viName"><?= htmlspecialchars($active['visitor_name'] ?: 'Visitor') ?></b><br>
                    <small class="mut"><?= htmlspecialchars($active['user_agent'] ?: 'Desktop Browser') ?></small>
                </div>
                <button class="ib mob-only" data-info style="margin-left:auto" aria-label="Close">
                    <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M18 6L6 18M6 6l12 12"/></svg>
                </button>
            </div>
            <dl class="kv">
                <dt>Email</dt>
                <dd><?= htmlspecialchars($active['visitor_email'] ?: 'Not captured yet') ?></dd>
                <dt>Location</dt>
                <dd><?= htmlspecialchars($active['location'] ?: 'Pakistan') ?></dd>
                <dt>IP Address</dt>
                <dd><code><?= htmlspecialchars($active['visitor_ip'] ?: '127.0.0.1') ?></code></dd>
                <dt>Current Page</dt>
                <dd style="word-break:break-all; font-size:12px;"><?= htmlspecialchars($active['current_page'] ?: '/') ?></dd>
                <dt>Source</dt>
                <dd><?= htmlspecialchars($profile['source'] ?? 'Direct') ?></dd>
                <dt>Sessions</dt>
                <dd><?= (int)($profile['sessions_count'] ?? 1) ?> visits</dd>
                <dt>Lead score</dt>
                <dd><span class="score" style="--s:<?= (int)($profile['lead_score'] ?? 65) ?>"><span><?= (int)($profile['lead_score'] ?? 65) ?></span></span></dd>
            </dl>
            <hr class="s">
            <div class="sec-t" style="font-size:14px">Recent Pages Viewed</div>
            <ul class="list" style="font-size:13px; max-height:160px; overflow-y:auto;">
                <?php if (!empty($profile['pages'])): ?>
                    <?php foreach ($profile['pages'] as $p): ?>
                        <li>
                            <div class="who">
                                <b><?= htmlspecialchars($p['path']) ?></b>
                                <small><?= htmlspecialchars($p['time']) ?></small>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>
                        <div class="who">
                            <b><?= htmlspecialchars($active['current_page'] ?: '/') ?></b>
                            <small>current</small>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
            <hr class="s">
            <div class="sec-t" style="font-size:14px; margin-bottom:10px">Session details</div>
            <ul class="tl">
                <li><b><?= date('H:i', strtotime($active['created_at'])) ?> · Landed</b><small><?= htmlspecialchars($active['current_page'] ?: 'Home') ?></small></li>
                <li class="c"><b><?= date('H:i', strtotime($active['updated_at'])) ?> · Chat active</b><small><?= htmlspecialchars($active['status']) ?></small></li>
            </ul>
            <a class="btn" style="width:100%;margin-top:6px" href="<?= base_url('/admin/visitors') ?>">Full visitor analytics</a>
        </aside>
    <?php endif; ?>
</section>

<!-- Audio alert for incoming chat requests -->
<audio id="chatBeepAudio" preload="auto">
    <source src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3" type="audio/mpeg">
</audio>

<script>
(function() {
    const activeConvId = <?= $active ? (int)$active['id'] : 0 ?>;
    const currentTab = '<?= addslashes($currentTab) ?>';
    const pollUrl = '<?= base_url('/admin/live-chat/poll') ?>';
    const sendUrl = '<?= base_url('/admin/live-chat/send') ?>';
    const takeoverUrl = '<?= base_url('/admin/live-chat/takeover') ?>';
    const closeUrl = '<?= base_url('/admin/live-chat/close') ?>';

    const msgsContainer = document.getElementById('msgs');
    const cmpTxt = document.getElementById('cmpTxt');
    const cmpSend = document.getElementById('cmpSend');
    const takeoverBox = document.getElementById('takeover');
    const tkLbl = document.getElementById('tkLbl');
    const btnClose = document.getElementById('btnCloseChat');
    const beepAudio = document.getElementById('chatBeepAudio');

    let lastMsgId = 0;
    if (msgsContainer) {
        const existing = msgsContainer.querySelectorAll('[data-mid]');
        if (existing.length > 0) {
            lastMsgId = parseInt(existing[existing.length - 1].getAttribute('data-mid')) || 0;
        }
        msgsContainer.scrollTop = msgsContainer.scrollHeight;
    }

    // Canned responses click
    document.querySelectorAll('.canned-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if (cmpTxt) {
                cmpTxt.value = btn.getAttribute('data-t');
                cmpTxt.focus();
            }
        });
    });

    // Send Message
    async function sendMessage() {
        if (!cmpTxt || !activeConvId) return;
        const msg = cmpTxt.value.trim();
        if (!msg) return;

        cmpSend.disabled = true;
        try {
            const res = await fetch(sendUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ conversation_id: activeConvId, message: msg })
            });
            const data = await res.json();
            if (data.success) {
                appendMsg('a', msg, 'Amaanullah (You)', data.created_at || 'Just now', data.message_id);
                cmpTxt.value = '';
                if (takeoverBox && !takeoverBox.checked) {
                    takeoverBox.checked = true;
                    if (tkLbl) tkLbl.textContent = 'Human handling';
                }
            }
        } catch (e) {
            console.error('Send message error:', e);
        } finally {
            cmpSend.disabled = false;
            cmpTxt.focus();
        }
    }

    if (cmpSend) cmpSend.addEventListener('click', sendMessage);
    if (cmpTxt) {
        cmpTxt.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });
    }

    function appendMsg(senderClass, text, senderLabel, timeStr, mid) {
        if (!msgsContainer) return;
        const div = document.createElement('div');
        div.className = 'm ' + senderClass;
        if (mid) div.setAttribute('data-mid', mid);
        div.innerHTML = text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/\n/g, '<br>') + 
            `<small>${senderLabel} · ${timeStr}</small>`;
        msgsContainer.appendChild(div);
        msgsContainer.scrollTop = msgsContainer.scrollHeight;
        if (mid && mid > lastMsgId) lastMsgId = mid;
    }

    // Takeover toggle
    if (takeoverBox) {
        takeoverBox.addEventListener('change', async () => {
            const isChecked = takeoverBox.checked;
            if (tkLbl) tkLbl.textContent = isChecked ? 'Human handling' : 'Bot is handling';
            try {
                await fetch(takeoverUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ conversation_id: activeConvId, takeover: isChecked })
                });
            } catch (e) {
                console.error('Takeover toggle failed:', e);
            }
        });
    }

    // Close chat
    if (btnClose) {
        btnClose.addEventListener('click', async () => {
            if (!confirm('Are you sure you want to close this conversation?')) return;
            try {
                await fetch(closeUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ conversation_id: activeConvId })
                });
                window.location.reload();
            } catch (e) {
                console.error('Close chat failed:', e);
            }
        });
    }

    // Search filter
    const chatSearchInp = document.getElementById('chatSearchInp');
    if (chatSearchInp) {
        chatSearchInp.addEventListener('input', () => {
            const term = chatSearchInp.value.toLowerCase();
            document.querySelectorAll('#cvl .cv').forEach(el => {
                const text = el.textContent.toLowerCase();
                el.style.display = text.includes(term) ? '' : 'none';
            });
        });
    }

    // Real-time polling every 2.5 seconds
    let previousNeedsCount = <?= (int)$needsCount ?>;
    setInterval(async () => {
        try {
            const res = await fetch(`${pollUrl}?conversation_id=${activeConvId}&last_msg_id=${lastMsgId}&tab=${encodeURIComponent(currentTab)}`);
            const data = await res.json();

            // Check if needs human count increased -> trigger sound alert
            const needsPill = document.getElementById('needsYouPill');
            if (data.needs_human_count !== undefined) {
                if (data.needs_human_count > previousNeedsCount) {
                    try { beepAudio.play(); } catch(err) {}
                }
                previousNeedsCount = data.needs_human_count;
                if (needsPill) {
                    needsPill.textContent = data.needs_human_count;
                    needsPill.style.display = data.needs_human_count > 0 ? 'inline-block' : 'none';
                }
            }

            // Append new incoming messages
            if (data.messages && data.messages.length > 0) {
                let hasNewUserMsg = false;
                data.messages.forEach(m => {
                    if (m.id > lastMsgId) {
                        const sClass = m.sender === 'visitor' ? 'v' : (m.sender === 'admin' ? 'a' : 'b');
                        const sLabel = m.sender === 'visitor' ? 'Visitor' : (m.sender === 'admin' ? 'Amaanullah (You)' : 'Bot');
                        appendMsg(sClass, m.message, sLabel, m.created_at ? m.created_at.substr(11, 5) : 'Now', m.id);
                        if (m.sender === 'visitor') hasNewUserMsg = true;
                    }
                });
                if (hasNewUserMsg) {
                    try { beepAudio.play(); } catch(err) {}
                }
            }

            // Sync takeover box state if changed by visitor requesting handoff
            if (data.active_status && takeoverBox) {
                if (data.active_status === 'needs_human' || data.active_status === 'active') {
                    if (!takeoverBox.checked) {
                        takeoverBox.checked = true;
                        if (tkLbl) tkLbl.textContent = 'Human handling';
                    }
                }
            }
        } catch (e) {
            // Silently ignore network poll drop
        }
    }, 2500);
})();
</script>

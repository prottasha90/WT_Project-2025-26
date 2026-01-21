document.addEventListener('DOMContentLoaded', function () {
    console.log('Admin System Online');

    const logsTableBody = document.querySelector('tbody');
    const refreshBtn = document.createElement('button');
    refreshBtn.innerText = 'Refresh Transmissions';
    refreshBtn.className = 'btn btn-secondary';
    refreshBtn.style.marginTop = '1rem';
    refreshBtn.style.width = 'auto';

    // Append button if we are on dashboard (check if table exists)
    if (logsTableBody) {
        // Find the specific table for logs
        const headers = document.querySelectorAll('h3');
        let logsHeader = null;
        headers.forEach(h => {
            if (h.innerText.includes('Transmissions')) logsHeader = h;
        });

        if (logsHeader) {
            logsHeader.appendChild(document.createTextNode(' '));
            logsHeader.appendChild(refreshBtn);

            refreshBtn.addEventListener('click', function () {
                fetch('index.php?action=api_get_recent_logs')
                    .then(response => response.json())
                    .then(data => {
                        logsTableBody.innerHTML = '';
                        if (data.length === 0) {
                            logsTableBody.innerHTML = '<tr><td colspan="4">No recent transmissions received.</td></tr>';
                            return;
                        }

                        data.forEach(log => {
                            const row = `
                                <tr>
                                    <td>${log.log_date}</td>
                                    <td>${escapeHtml(log.mission_title)}</td>
                                    <td>${escapeHtml(log.astronaut_name)}</td>
                                    <td>${escapeHtml(log.log_content)}</td>
                                </tr>
                            `;
                            logsTableBody.insertAdjacentHTML('beforeend', row);
                        });
                        alert('Data Refreshed');
                    })
                    .catch(err => console.error('Data Transmission Error', err));
            });
        }
    }
});

function escapeHtml(text) {
    if (!text) return '';
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

window.renderPetMap = function (containerId, points) {

    if (!points?.length) return;

    const el = document.getElementById(containerId);
    if (!el) return;

    window.maps ??= {};

    if (window.maps[containerId]) {
        window.maps[containerId].remove();
    }

    //  FIX CLAVE
    if (el._leaflet_id) {
        el._leaflet_id = null;
    }

    el.innerHTML = "";

    const map = L.map(containerId, { preferCanvas: true });
    window.maps[containerId] = map;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    const latlngs = points.map(p => [p.lat, p.lng]);

    L.polyline(latlngs, { color: 'red', weight: 4 }).addTo(map);

    points.forEach((p, i) => {

        const isLast = i === points.length - 1;

        const icon = L.icon({
            iconUrl: isLast
                ? 'https://maps.google.com/mapfiles/ms/icons/red-dot.png'
                : 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png',
            iconSize: isLast ? [32, 32] : [28, 28],
            iconAnchor: isLast ? [16, 32] : [14, 28]
        });

        L.marker([p.lat, p.lng], { icon })
            .addTo(map)
            .bindPopup(`
                <div style="width:200px;">
                    ${p.photo ? `<img src="/storage/${p.photo}" style="width:100%;height:120px;object-fit:cover;border-radius:8px;margin-bottom:6px;" />` : ''}
                    <div>${p.message ?? 'Sin mensaje'}</div>
                    <div style="font-size:11px;color:gray;">
                        ${isLast ? 'Última ubicación' : p.time}
                    </div>
                </div>
            `);
    });

    map.fitBounds(latlngs, { padding: [30, 30] });

    setTimeout(() => map.invalidateSize(), 100);
};
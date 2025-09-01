// Simple debug modal function - fallback if main modal fails
function openSimpleModal(showtimeId) {
    console.log('Opening simple modal fallback');
    
    // Remove any existing simple modals
    const existingModal = document.getElementById('simple-debug-modal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Create simple modal
    const modal = document.createElement('div');
    modal.id = 'simple-debug-modal';
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    `;
    
    modal.innerHTML = `
        <div style="
            background: white;
            border-radius: 16px;
            padding: 32px;
            max-width: 400px;
            width: 90%;
            text-align: center;
        ">
            <h2 style="color: #333; margin: 0 0 16px 0; font-size: 24px; font-weight: bold;">
                How many seats needed?
            </h2>
            <div style="color: #666; margin-bottom: 24px;">
                Showtime ID: ${showtimeId}
            </div>
            <div style="margin: 24px 0;">
                <button onclick="changeSeatCountSimple(-1)" style="
                    background: #ccc;
                    border: none;
                    border-radius: 50%;
                    width: 40px;
                    height: 40px;
                    margin-right: 20px;
                    cursor: pointer;
                ">-</button>
                <span id="simple-seat-count" style="font-size: 48px; font-weight: bold; margin: 0 20px;">1</span>
                <button onclick="changeSeatCountSimple(1)" style="
                    background: #ccc;
                    border: none;
                    border-radius: 50%;
                    width: 40px;
                    height: 40px;
                    margin-left: 20px;
                    cursor: pointer;
                ">+</button>
            </div>
            <button onclick="proceedSimple(${showtimeId})" style="
                background: #fff;
                border: 2px solid #333;
                border-radius: 8px;
                padding: 12px 24px;
                margin-right: 12px;
                cursor: pointer;
                font-weight: bold;
            ">Continue</button>
            <button onclick="closeSimpleModal()" style="
                background: #ccc;
                border: none;
                border-radius: 8px;
                padding: 12px 24px;
                cursor: pointer;
            ">Cancel</button>
        </div>
    `;
    
    document.body.appendChild(modal);
    document.body.style.overflow = 'hidden';
}

let simpleSeatCount = 1;

function changeSeatCountSimple(delta) {
    const newCount = simpleSeatCount + delta;
    if (newCount >= 1 && newCount <= 6) {
        simpleSeatCount = newCount;
        document.getElementById('simple-seat-count').textContent = simpleSeatCount;
    }
}

function proceedSimple(showtimeId) {
    sessionStorage.setItem('selectedSeatCount', simpleSeatCount);
    window.location.href = `/booking/select-seats/${showtimeId}?seats=${simpleSeatCount}`;
}

function closeSimpleModal() {
    const modal = document.getElementById('simple-debug-modal');
    if (modal) {
        modal.remove();
        document.body.style.overflow = '';
    }
}

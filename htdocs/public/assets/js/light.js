document.addEventListener('DOMContentLoaded', () => {
    const light = document.getElementById('light');
    const elements = document.querySelectorAll('.main');
    let mouseInElement = false;
    elements.forEach(element => {
        element.addEventListener('mouseenter', () => {
            mouseInElement = true;
            light.style.visibility = 'visible';
            light.style.opacity = '1';
        });
        element.addEventListener('mouseleave', () => {
            mouseInElement = false;
            setTimeout(() => {
                if (!mouseInElement) {
                    light.style.opacity = '0';
                    setTimeout(() => {
                        light.style.visibility = 'hidden';
                    }, 300);
                }
            }, 0);
        });
        element.addEventListener('mousemove', (e) => {
            light.style.left = e.pageX + 'px';
            light.style.top = e.pageY + 'px';
        });
    });
    document.addEventListener('mousemove', (e) => {
        if (mouseInElement) {
            light.style.left = e.pageX + 'px';
            light.style.top = e.pageY + 'px';
        }
    });
});

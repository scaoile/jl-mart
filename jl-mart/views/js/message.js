
        document.addEventListener('DOMContentLoaded', (event) => {
            const urlParams = new URLSearchParams(window.location.search);
            const message = urlParams.get('message');
            if (message) {
                const messageElement = document.createElement('div');
                messageElement.textContent = message;
                messageElement.style.position = 'fixed';
                messageElement.style.top = '15%';
                messageElement.style.left = '50%';
                messageElement.style.transform = 'translate(-50%, -50%)';
                messageElement.style.backgroundColor = '#DD4AA7';
                messageElement.style.color = 'white';
                messageElement.style.padding = '20px 40px';
                messageElement.style.borderRadius = '10px';
                document.body.appendChild(messageElement);

                setTimeout(() => {
                    messageElement.style.transition = 'opacity 1s';
                    messageElement.style.opacity = '0';
                    setTimeout(() => {
                        messageElement.remove();
                    }, 1000);
                }, 3000);
            }
        });
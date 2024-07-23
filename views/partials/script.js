document.addEventListener('DOMContentLoaded', () => {
    const imageDialog = document.getElementById('imageDialog');
    const dialogImage = document.getElementById('dialogImage');
    const closeDialog = document.getElementById('closeDialog');

    document.querySelectorAll('img[id^="profileImage"]').forEach(profileImage => {
        profileImage.addEventListener('click', () => {
            const userImage = profileImage.getAttribute('data-user-image');
            dialogImage.src = userImage;
            imageDialog.style.display = 'flex';
        });
    });

    closeDialog.addEventListener('click', () => {
        imageDialog.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === imageDialog) {
            imageDialog.style.display = 'none';
        }
    });
});
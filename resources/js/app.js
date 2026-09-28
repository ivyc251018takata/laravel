document.querySelectorAll('[data-copy-target]').forEach((button) => {
	button.addEventListener('click', async () => {
		const target = document.getElementById(button.dataset.copyTarget);

		if (!target) {
			return;
		}

		try {
			await navigator.clipboard.writeText(target.textContent.trim());
		} catch {
			const textArea = document.createElement('textarea');
			textArea.value = target.textContent.trim();
			textArea.setAttribute('readonly', '');
			textArea.style.position = 'fixed';
			textArea.style.opacity = '0';
			document.body.appendChild(textArea);
			textArea.select();
			document.execCommand('copy');
			textArea.remove();
		}

		const originalLabel = button.textContent;
		button.textContent = 'コピーしました';

		window.setTimeout(() => {
			button.textContent = originalLabel;
		}, 1600);
	});
});

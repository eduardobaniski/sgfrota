import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
	const modalId = 'page-help-modal';
	const modal = document.getElementById(modalId);

	if (!modal) {
		return;
	}

	const openTriggers = document.querySelectorAll(`[data-help-open="${modalId}"]`);
	const closeTriggers = modal.querySelectorAll('[data-help-close]');
	let lastFocusedElement = null;

	const focusableSelectors = 'a[href], button, textarea, input, select, [tabindex]:not([tabindex="-1"])';

	const handleKeydown = (event) => {
		if (event.key === 'Escape') {
			event.preventDefault();
			closeModal();
		}

		if (event.key === 'Tab') {
			const focusable = Array.from(modal.querySelectorAll(focusableSelectors)).filter((el) => !el.hasAttribute('disabled'));
			if (!focusable.length) {
				return;
			}

			const firstElement = focusable[0];
			const lastElement = focusable[focusable.length - 1];

			if (event.shiftKey && document.activeElement === firstElement) {
				event.preventDefault();
				lastElement.focus();
			} else if (!event.shiftKey && document.activeElement === lastElement) {
				event.preventDefault();
				firstElement.focus();
			}
		}
	};

	const openModal = () => {
		lastFocusedElement = document.activeElement;
		modal.classList.remove('hidden');
		modal.setAttribute('aria-hidden', 'false');
		const focusTarget = modal.querySelector('[data-help-focus]') || modal.querySelector(focusableSelectors);
		focusTarget?.focus();
		document.addEventListener('keydown', handleKeydown);
	};

	const closeModal = () => {
		modal.classList.add('hidden');
		modal.setAttribute('aria-hidden', 'true');
		document.removeEventListener('keydown', handleKeydown);
		if (lastFocusedElement) {
			lastFocusedElement.focus();
		}
	};

	openTriggers.forEach((trigger) => {
		trigger.addEventListener('click', (event) => {
			event.preventDefault();
			openModal();
		});
	});

	closeTriggers.forEach((trigger) => {
		trigger.addEventListener('click', (event) => {
			event.preventDefault();
			closeModal();
		});
	});

	modal.addEventListener('click', (event) => {
		if (event.target === modal) {
			closeModal();
		}
	});
});

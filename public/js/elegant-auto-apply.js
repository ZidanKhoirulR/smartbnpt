// Auto-apply elegant styles to elements
document.addEventListener('DOMContentLoaded', function () {

    // Function to apply elegant classes
    function applyElegantStyles() {

        // Apply button styles
        const buttons = document.querySelectorAll('button:not([class*="btn-elegant"]):not(.swal2-styled):not([class*="sidenav"]):not([class*="dropdown-toggle"])');
        buttons.forEach(button => {
            // Skip if already has elegant class or is a special button
            if (button.classList.contains('btn-elegant') ||
                button.classList.contains('btn-elegant-secondary') ||
                button.classList.contains('btn-elegant-success') ||
                button.classList.contains('btn-elegant-danger') ||
                button.classList.contains('btn-elegant-warning') ||
                button.closest('.swal2-actions') ||
                button.closest('[sidenav-trigger]') ||
                button.closest('[sidenav-close]')) {
                return;
            }

            // Determine button type based on context and attributes
            if (button.type === 'submit' || button.textContent.toLowerCase().includes('save') || button.textContent.toLowerCase().includes('submit')) {
                button.classList.add('btn-elegant');
            } else if (button.textContent.toLowerCase().includes('delete') || button.textContent.toLowerCase().includes('hapus') || button.classList.contains('btn-danger')) {
                button.classList.add('btn-elegant-danger');
            } else if (button.textContent.toLowerCase().includes('edit') || button.textContent.toLowerCase().includes('update')) {
                button.classList.add('btn-elegant');
            } else if (button.textContent.toLowerCase().includes('create') || button.textContent.toLowerCase().includes('add') || button.textContent.toLowerCase().includes('tambah')) {
                button.classList.add('btn-elegant-success');
            } else {
                button.classList.add('btn-elegant-secondary');
            }

            // Ensure button is visible
            button.style.zIndex = '10';
            button.style.position = 'relative';
            button.style.visibility = 'visible';
            button.style.opacity = '1';
            button.style.display = 'inline-flex';
            button.style.alignItems = 'center';
            button.style.justifyContent = 'center';
            button.style.minHeight = '44px';
        });

        // Apply form input styles
        const inputs = document.querySelectorAll('input:not([type="hidden"]):not([type="checkbox"]):not([type="radio"]):not([class*="form-elegant"])');
        inputs.forEach(input => {
            if (!input.classList.contains('form-elegant')) {
                input.classList.add('form-elegant');
            }
        });

        const selects = document.querySelectorAll('select:not([class*="form-elegant"])');
        selects.forEach(select => {
            if (!select.classList.contains('form-elegant')) {
                select.classList.add('form-elegant');
            }
        });

        const textareas = document.querySelectorAll('textarea:not([class*="form-elegant"])');
        textareas.forEach(textarea => {
            if (!textarea.classList.contains('form-elegant')) {
                textarea.classList.add('form-elegant');
            }
        });

        // Apply card styles to common containers
        const cards = document.querySelectorAll('.card:not([class*="card-elegant"]), .panel:not([class*="card-elegant"])');
        cards.forEach(card => {
            if (!card.classList.contains('card-elegant')) {
                card.classList.add('card-elegant');
            }
        });

        // Apply table styles
        const tables = document.querySelectorAll('table:not([class*="table-elegant"])');
        tables.forEach(table => {
            if (!table.classList.contains('table-elegant')) {
                table.classList.add('table-elegant');
            }
        });
    }

    // Initial application
    applyElegantStyles();

    // Re-apply on dynamic content changes
    const observer = new MutationObserver(function (mutations) {
        let shouldReapply = false;
        mutations.forEach(function (mutation) {
            if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                mutation.addedNodes.forEach(function (node) {
                    if (node.nodeType === 1 && (node.tagName === 'BUTTON' || node.tagName === 'INPUT' || node.tagName === 'SELECT' || node.tagName === 'TEXTAREA' || node.querySelector)) {
                        shouldReapply = true;
                    }
                });
            }
        });

        if (shouldReapply) {
            setTimeout(applyElegantStyles, 100);
        }
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });

    // Enhanced form submission handling
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton && !submitButton.disabled) {
                submitButton.disabled = true;

                const originalContent = submitButton.innerHTML;
                const hasIcon = submitButton.querySelector('svg') || submitButton.querySelector('i');

                submitButton.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-current inline" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Processing...
                `;

                // Ensure button stays visible during processing
                submitButton.style.zIndex = '20';
                submitButton.style.position = 'relative';
                submitButton.style.visibility = 'visible';
                submitButton.style.opacity = '0.8';

                // Fallback to reset button after 15 seconds
                setTimeout(() => {
                    if (submitButton.disabled) {
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalContent;
                        submitButton.style.opacity = '1';
                    }
                }, 15000);
            }
        });
    });

    // Enhanced SweetAlert2 styling
    if (typeof Swal !== 'undefined') {
        const originalFire = Swal.fire;
        Swal.fire = function (...args) {
            const result = originalFire.apply(this, args);

            // Apply custom styling after modal opens
            setTimeout(() => {
                const confirmButton = document.querySelector('.swal2-confirm');
                const cancelButton = document.querySelector('.swal2-cancel');
                const denyButton = document.querySelector('.swal2-deny');

                if (confirmButton) {
                    confirmButton.style.background = 'linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%)';
                    confirmButton.style.border = 'none';
                    confirmButton.style.borderRadius = '0.75rem';
                    confirmButton.style.fontWeight = '600';
                    confirmButton.style.padding = '0.75rem 1.5rem';
                    confirmButton.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1)';
                    confirmButton.style.transform = 'scale(1)';
                    confirmButton.style.transition = 'all 0.2s ease';

                    confirmButton.addEventListener('mouseenter', () => {
                        confirmButton.style.transform = 'scale(1.05) translateY(-2px)';
                        confirmButton.style.boxShadow = '0 20px 25px -5px rgba(0, 0, 0, 0.1)';
                    });

                    confirmButton.addEventListener('mouseleave', () => {
                        confirmButton.style.transform = 'scale(1)';
                        confirmButton.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1)';
                    });
                }

                if (cancelButton) {
                    cancelButton.style.background = 'linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%)';
                    cancelButton.style.color = '#475569';
                    cancelButton.style.border = '1px solid #cbd5e1';
                    cancelButton.style.borderRadius = '0.75rem';
                    cancelButton.style.fontWeight = '600';
                    cancelButton.style.padding = '0.75rem 1.5rem';
                    cancelButton.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1)';
                    cancelButton.style.transform = 'scale(1)';
                    cancelButton.style.transition = 'all 0.2s ease';

                    cancelButton.addEventListener('mouseenter', () => {
                        cancelButton.style.transform = 'scale(1.05) translateY(-2px)';
                        cancelButton.style.background = 'linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%)';
                    });

                    cancelButton.addEventListener('mouseleave', () => {
                        cancelButton.style.transform = 'scale(1)';
                        cancelButton.style.background = 'linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%)';
                    });
                }

                if (denyButton) {
                    denyButton.style.background = 'linear-gradient(135deg, #ef4444 0%, #f43f5e 100%)';
                    denyButton.style.border = 'none';
                    denyButton.style.borderRadius = '0.75rem';
                    denyButton.style.fontWeight = '600';
                    denyButton.style.padding = '0.75rem 1.5rem';
                    denyButton.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1)';
                    denyButton.style.transform = 'scale(1)';
                    denyButton.style.transition = 'all 0.2s ease';

                    denyButton.addEventListener('mouseenter', () => {
                        denyButton.style.transform = 'scale(1.05) translateY(-2px)';
                        denyButton.style.boxShadow = '0 20px 25px -5px rgba(0, 0, 0, 0.1)';
                    });

                    denyButton.addEventListener('mouseleave', () => {
                        denyButton.style.transform = 'scale(1)';
                        denyButton.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1)';
                    });
                }
            }, 100);

            return result;
        };
    }

    // Enhanced notification system
    window.showElegantNotification = function (message, type = 'info', duration = 5000) {
        const notification = document.createElement('div');
        const id = 'notification-' + Date.now();
        notification.id = id;

        const typeClasses = {
            'success': 'bg-gradient-to-r from-emerald-50 to-teal-50 border-emerald-200 text-emerald-800',
            'error': 'bg-gradient-to-r from-red-50 to-rose-50 border-red-200 text-red-800',
            'warning': 'bg-gradient-to-r from-amber-50 to-yellow-50 border-amber-200 text-amber-800',
            'info': 'bg-gradient-to-r from-blue-50 to-indigo-50 border-blue-200 text-blue-800'
        };

        const icons = {
            'success': '<svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            'error': '<svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path></svg>',
            'warning': '<svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path></svg>',
            'info': '<svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
        };

        notification.className = `fixed top-6 right-6 max-w-md p-4 rounded-2xl shadow-2xl z-50 transform transition-all duration-300 border ${typeClasses[type] || typeClasses.info} translate-x-full`;
        notification.innerHTML = `
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    ${icons[type] || icons.info}
                </div>
                <div class="flex-1">
                    <p class="font-medium">${message}</p>
                </div>
                <button onclick="document.getElementById('${id}').remove()" class="flex-shrink-0 text-current opacity-70 hover:opacity-100 transition-opacity rounded-lg p-1 hover:bg-black/5">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/>
                    </svg>
                </button>
            </div>
        `;

        document.body.appendChild(notification);

        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);

        // Auto remove
        setTimeout(() => {
            if (document.getElementById(id)) {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (document.getElementById(id)) {
                        notification.remove();
                    }
                }, 300);
            }
        }, duration);
    };

    // Expose functions globally
    window.applyElegantStyles = applyElegantStyles;

    // Console message for debugging
    console.log('🎨 Elegant styles system initialized');
});
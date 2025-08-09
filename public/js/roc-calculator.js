/**
 * ROC (Rank Order Centroid) Calculator
 * Modul untuk menghitung bobot ROC berdasarkan ranking kriteria
 * 
 * Formula: w_i = (1/K) × Σ(1/j) untuk j = i sampai K
 * dimana:
 * - w_i = bobot untuk kriteria dengan ranking i
 * - K = total jumlah kriteria
 * 
 * @author Your Name
 * @version 1.0
 */

class ROCCalculator {
    constructor() {
        this.weights = [];
        this.totalCriteria = 0;
    }

    /**
     * Hitung bobot ROC untuk semua ranking
     * @param {number} totalCriteria - Total jumlah kriteria
     * @returns {Array} Array berisi bobot untuk setiap ranking
     */
    calculateAllWeights(totalCriteria) {
        this.totalCriteria = totalCriteria;
        this.weights = [];

        for (let i = 1; i <= totalCriteria; i++) {
            const weight = this.calculateSingleWeight(i, totalCriteria);
            this.weights.push({
                ranking: i,
                weight: weight,
                percentage: weight * 100
            });
        }

        return this.weights;
    }

    /**
     * Hitung bobot ROC untuk ranking tertentu
     * @param {number} ranking - Ranking kriteria (1, 2, 3, ...)
     * @param {number} totalCriteria - Total jumlah kriteria
     * @returns {number} Bobot ROC (0-1)
     */
    calculateSingleWeight(ranking, totalCriteria) {
        if (!ranking || ranking < 1 || ranking > totalCriteria) {
            throw new Error('Ranking harus antara 1 dan ' + totalCriteria);
        }

        let sum = 0;
        for (let j = ranking; j <= totalCriteria; j++) {
            sum += 1 / j;
        }

        const weight = (1 / totalCriteria) * sum;
        return parseFloat(weight.toFixed(6)); // 6 decimal precision
    }

    /**
     * Hitung bobot ROC dalam persentase
     * @param {number} ranking - Ranking kriteria
     * @param {number} totalCriteria - Total jumlah kriteria
     * @returns {number} Bobot dalam persentase (0-100)
     */
    calculatePercentage(ranking, totalCriteria) {
        const weight = this.calculateSingleWeight(ranking, totalCriteria);
        return parseFloat((weight * 100).toFixed(4)); // 4 decimal precision for percentage
    }

    /**
     * Validasi apakah total bobot = 1 (100%)
     * @param {number} totalCriteria - Total jumlah kriteria
     * @returns {Object} Hasil validasi
     */
    validateTotalWeight(totalCriteria) {
        const weights = this.calculateAllWeights(totalCriteria);
        const totalWeight = weights.reduce((sum, item) => sum + item.weight, 0);
        const tolerance = 0.000001; // Toleransi untuk floating point

        return {
            isValid: Math.abs(totalWeight - 1.0) < tolerance,
            totalWeight: totalWeight,
            totalPercentage: totalWeight * 100,
            difference: Math.abs(totalWeight - 1.0),
            weights: weights
        };
    }

    /**
     * Generate tabel bobot ROC untuk ditampilkan
     * @param {number} totalCriteria - Total jumlah kriteria
     * @returns {string} HTML table
     */
    generateWeightTable(totalCriteria) {
        const weights = this.calculateAllWeights(totalCriteria);
        let html = `
            <table class="table table-bordered table-sm">
                <thead class="table-dark">
                    <tr>
                        <th>Ranking</th>
                        <th>Bobot ROC</th>
                        <th>Persentase (%)</th>
                        <th>Kepentingan</th>
                    </tr>
                </thead>
                <tbody>
        `;

        weights.forEach((item, index) => {
            const importance = this.getImportanceLevel(item.ranking, totalCriteria);
            html += `
                <tr>
                    <td class="text-center">${item.ranking}</td>
                    <td class="text-center">${item.weight.toFixed(6)}</td>
                    <td class="text-center">${item.percentage.toFixed(4)}%</td>
                    <td class="text-center">
                        <span class="badge bg-${importance.color}">${importance.label}</span>
                    </td>
                </tr>
            `;
        });

        const validation = this.validateTotalWeight(totalCriteria);
        html += `
                </tbody>
                <tfoot class="table-secondary">
                    <tr>
                        <th>Total</th>
                        <th>${validation.totalWeight.toFixed(6)}</th>
                        <th>${validation.totalPercentage.toFixed(4)}%</th>
                        <th>
                            <span class="badge bg-${validation.isValid ? 'success' : 'danger'}">
                                ${validation.isValid ? 'Valid' : 'Invalid'}
                            </span>
                        </th>
                    </tr>
                </tfoot>
            </table>
        `;

        return html;
    }

    /**
     * Mendapatkan level kepentingan berdasarkan ranking
     * @param {number} ranking - Ranking kriteria
     * @param {number} totalCriteria - Total kriteria
     * @returns {Object} Level kepentingan dengan label dan warna
     */
    getImportanceLevel(ranking, totalCriteria) {
        const ratio = ranking / totalCriteria;

        if (ratio <= 0.2) {
            return { label: 'Sangat Penting', color: 'danger' };
        } else if (ratio <= 0.4) {
            return { label: 'Penting', color: 'warning' };
        } else if (ratio <= 0.6) {
            return { label: 'Cukup Penting', color: 'info' };
        } else if (ratio <= 0.8) {
            return { label: 'Kurang Penting', color: 'secondary' };
        } else {
            return { label: 'Tidak Penting', color: 'light' };
        }
    }

    /**
     * Format angka dengan separator ribuan
     * @param {number} number - Angka yang akan diformat
     * @param {number} decimals - Jumlah decimal places
     * @returns {string} Angka yang sudah diformat
     */
    formatNumber(number, decimals = 4) {
        return new Intl.NumberFormat('id-ID', {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals
        }).format(number);
    }

    /**
     * Export bobot ROC ke format CSV
     * @param {number} totalCriteria - Total kriteria
     * @returns {string} Data CSV
     */
    exportToCSV(totalCriteria) {
        const weights = this.calculateAllWeights(totalCriteria);
        let csv = 'Ranking,Bobot ROC,Persentase,Kepentingan\n';

        weights.forEach(item => {
            const importance = this.getImportanceLevel(item.ranking, totalCriteria);
            csv += `${item.ranking},${item.weight.toFixed(6)},${item.percentage.toFixed(4)},${importance.label}\n`;
        });

        return csv;
    }

    /**
     * Reset calculator
     */
    reset() {
        this.weights = [];
        this.totalCriteria = 0;
    }
}

// Utility Functions untuk penggunaan langsung di HTML

/**
 * Hitung bobot ROC untuk ranking tertentu (Global Function)
 * @param {number} ranking - Ranking kriteria
 * @param {number} totalCriteria - Total kriteria
 * @returns {number} Bobot dalam persentase
 */
function calculateROC(ranking, totalCriteria) {
    const calculator = new ROCCalculator();
    return calculator.calculatePercentage(ranking, totalCriteria);
}

/**
 * Validasi ranking dan hitung bobot ROC (Global Function)
 * @param {number} ranking - Ranking yang dipilih
 * @param {number} totalCriteria - Total kriteria
 * @param {Array} existingRankings - Array ranking yang sudah ada
 * @returns {Object} Hasil validasi dan perhitungan
 */
function validateAndCalculateROC(ranking, totalCriteria, existingRankings = []) {
    const calculator = new ROCCalculator();

    const result = {
        isValid: true,
        messages: [],
        weight: 0,
        percentage: 0
    };

    // Validasi input
    if (!ranking || ranking < 1 || ranking > totalCriteria) {
        result.isValid = false;
        result.messages.push(`Ranking harus antara 1 dan ${totalCriteria}`);
        return result;
    }

    // Validasi duplikat
    if (existingRankings.includes(ranking)) {
        result.isValid = false;
        result.messages.push('Ranking sudah digunakan oleh kriteria lain');
        return result;
    }

    // Hitung bobot jika valid
    try {
        result.weight = calculator.calculateSingleWeight(ranking, totalCriteria);
        result.percentage = calculator.calculatePercentage(ranking, totalCriteria);
        result.messages.push('Perhitungan ROC berhasil');
    } catch (error) {
        result.isValid = false;
        result.messages.push('Error: ' + error.message);
    }

    return result;
}

/**
 * Generate preview HTML untuk bobot ROC
 * @param {number} ranking - Ranking yang dipilih
 * @param {number} totalCriteria - Total kriteria
 * @returns {string} HTML preview
 */
function generateROCPreview(ranking, totalCriteria) {
    if (!ranking || !totalCriteria) {
        return '<div class="text-muted">Pilih ranking untuk melihat preview bobot ROC</div>';
    }

    const calculator = new ROCCalculator();
    const percentage = calculator.calculatePercentage(ranking, totalCriteria);
    const importance = calculator.getImportanceLevel(ranking, totalCriteria);

    return `
        <div class="roc-preview p-3 border rounded" style="background: linear-gradient(135deg, #f0fdf4, #dcfce7);">
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="ri-calculator-line text-success"></i>
                <span class="fw-semibold text-success">Preview Bobot ROC:</span>
            </div>
            <div class="fs-4 fw-bold text-success mb-1">${percentage}%</div>
            <div class="small text-success mb-2">
                Ranking ${ranking} dari ${totalCriteria} kriteria
            </div>
            <div class="small">
                <span class="badge bg-${importance.color}">${importance.label}</span>
            </div>
        </div>
    `;
}

// Export untuk penggunaan sebagai modul
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        ROCCalculator,
        calculateROC,
        validateAndCalculateROC,
        generateROCPreview
    };
}

// Make available globally
window.ROCCalculator = ROCCalculator;
window.calculateROC = calculateROC;
window.validateAndCalculateROC = validateAndCalculateROC;
window.generateROCPreview = generateROCPreview;

console.log('ROC Calculator loaded successfully');
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISKA - Wizard Instalasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .wizard-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .wizard-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .wizard-steps {
            padding: 2rem;
            border-bottom: 1px solid #eee;
        }
        .step-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            margin: 0.5rem 0;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .step-item.active {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
        }
        .step-item.completed {
            background: #e8f5e8;
            border-left: 4px solid #4caf50;
        }
        .step-icon {
            font-size: 2rem;
            margin-right: 1rem;
        }
        .step-content h5 {
            margin: 0;
            font-weight: 600;
        }
        .step-content p {
            margin: 0;
            color: #666;
            font-size: 0.9rem;
        }
        .wizard-body {
            padding: 2rem;
            min-height: 400px;
        }
        .wizard-footer {
            padding: 1.5rem 2rem;
            background: #f8f9fa;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-wizard {
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .progress-bar {
            height: 6px;
            border-radius: 3px;
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .alert {
            border-radius: 10px;
            border: none;
        }
        .loading-spinner {
            display: none;
        }
        .loading-spinner.show {
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="wizard-container">
                    <!-- Header -->
                    <div class="wizard-header">
                        <h1 class="mb-2">
                            <i class="fas fa-graduation-cap me-3"></i>
                            SISKA
                        </h1>
                        <p class="mb-0">Sistem Informasi Sekolah Bidang Kesiswaan</p>
                        <small>Wizard Instalasi</small>
                    </div>

                    <!-- Steps -->
                    <div class="wizard-steps">
                        <div class="row">
                            <div class="col-md-8">
                                <div id="steps-container">
                                    <!-- Steps will be loaded here -->
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <h6>Progress Instalasi</h6>
                                    <div class="progress mb-2">
                                        <div id="progress-bar" class="progress-bar bg-primary" role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <small id="progress-text">0% Complete</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="wizard-body">
                        <div id="step-content">
                            <!-- Step content will be loaded here -->
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="wizard-footer">
                        <button type="button" id="btn-prev" class="btn btn-outline-secondary btn-wizard" style="display: none;">
                            <i class="fas fa-arrow-left me-2"></i>Sebelumnya
                        </button>
                        <div class="ms-auto">
                            <button type="button" id="btn-next" class="btn btn-primary btn-wizard">
                                Selanjutnya<i class="fas fa-arrow-right ms-2"></i>
                            </button>
                            <button type="button" id="btn-complete" class="btn btn-success btn-wizard" style="display: none;">
                                <i class="fas fa-check me-2"></i>Selesai
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    <div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center py-5">
                    <div class="spinner-border text-primary mb-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <h5 id="loading-title">Memproses...</h5>
                    <p id="loading-message" class="text-muted">Mohon tunggu sebentar</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        class WizardInstaller {
            constructor() {
                this.currentStep = 1;
                this.totalSteps = 6;
                this.steps = [];
                this.init();
            }

            async init() {
                await this.loadSteps();
                this.bindEvents();
                this.loadStepContent(1);
            }

            async loadSteps() {
                try {
                    const response = await axios.get('/installer/api/steps');
                    this.steps = response.data.data;
                    this.renderSteps();
                } catch (error) {
                    console.error('Error loading steps:', error);
                    this.showAlert('error', 'Gagal memuat langkah instalasi');
                }
            }

            renderSteps() {
                const container = document.getElementById('steps-container');
                container.innerHTML = this.steps.map(step => `
                    <div class="step-item ${step.active ? 'active' : ''} ${step.completed ? 'completed' : ''}" data-step="${step.id}">
                        <div class="step-icon">${step.icon}</div>
                        <div class="step-content">
                            <h5>${step.title}</h5>
                            <p>${step.description}</p>
                        </div>
                    </div>
                `).join('');
            }

            bindEvents() {
                document.getElementById('btn-next').addEventListener('click', () => this.nextStep());
                document.getElementById('btn-prev').addEventListener('click', () => this.prevStep());
                document.getElementById('btn-complete').addEventListener('click', () => this.completeInstallation());
            }

            async loadStepContent(stepNumber) {
                const content = document.getElementById('step-content');
                
                switch(stepNumber) {
                    case 1:
                        content.innerHTML = this.getStep1Content();
                        break;
                    case 2:
                        content.innerHTML = this.getStep2Content();
                        await this.loadAvailableJenjang();
                        break;
                    case 3:
                        content.innerHTML = this.getStep3Content();
                        break;
                    case 4:
                        content.innerHTML = this.getStep4Content();
                        break;
                    case 5:
                        content.innerHTML = this.getStep5Content();
                        break;
                    case 6:
                        content.innerHTML = this.getStep6Content();
                        break;
                }

                this.updateStepStatus(stepNumber);
                this.updateButtons(stepNumber);
            }

            getStep1Content() {
                return `
                    <h4 class="mb-4">📋 Informasi Lisensi & Sekolah</h4>
                    <form id="form-step-1">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Informasi Lisensi</h6>
                                <div class="mb-3">
                                    <label class="form-label">Tipe Lisensi</label>
                                    <select class="form-select" name="license[type]" required>
                                        <option value="">Pilih Tipe Lisensi</option>
                                        <option value="trial">Trial (30 hari)</option>
                                        <option value="single">Single School</option>
                                        <option value="multi">Multi School</option>
                                        <option value="enterprise">Enterprise</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">License Key</label>
                                    <input type="text" class="form-control" name="license[key]" placeholder="Masukkan license key" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Informasi Sekolah</h6>
                                <div class="mb-3">
                                    <label class="form-label">Nama Sekolah</label>
                                    <input type="text" class="form-control" name="sekolah[nama_sekolah]" placeholder="Nama sekolah" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jenis Sekolah</label>
                                    <select class="form-select" name="sekolah[jenis_sekolah]" required>
                                        <option value="">Pilih Jenis Sekolah</option>
                                        <option value="SD">SD (Sekolah Dasar)</option>
                                        <option value="SMP">SMP (Sekolah Menengah Pertama)</option>
                                        <option value="SMA">SMA (Sekolah Menengah Atas)</option>
                                        <option value="SMK">SMK (Sekolah Menengah Kejuruan)</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <textarea class="form-control" name="sekolah[alamat]" rows="3" placeholder="Alamat lengkap sekolah" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Telepon</label>
                                    <input type="text" class="form-control" name="sekolah[telepon]" placeholder="Nomor telepon" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="sekolah[email]" placeholder="Email sekolah" required>
                                </div>
                            </div>
                        </div>
                    </form>
                `;
            }

            getStep2Content() {
                return `
                    <h4 class="mb-4">📚 Pilihan Jenjang Pendidikan</h4>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Pilih jenjang pendidikan yang akan diaktifkan berdasarkan lisensi Anda.
                    </div>
                    <div id="jenjang-options">
                        <!-- Jenjang options will be loaded here -->
                    </div>
                `;
            }

            getStep3Content() {
                return `
                    <h4 class="mb-4">🗄️ Konfigurasi Database</h4>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Pastikan database server sudah berjalan dan Anda memiliki akses untuk membuat database.
                    </div>
                    <form id="form-step-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Host Database</label>
                                    <input type="text" class="form-control" name="database[host]" value="localhost" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Port Database</label>
                                    <input type="number" class="form-control" name="database[port]" value="3306" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" name="database[username]" value="root" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="database[password]" placeholder="Password database">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prefix Database</label>
                            <input type="text" class="form-control" name="database[prefix]" value="siska_" placeholder="Prefix untuk nama database">
                            <div class="form-text">Database akan dibuat dengan format: prefix + jenjang (contoh: siska_sd, siska_smp)</div>
                        </div>
                    </form>
                `;
            }

            getStep4Content() {
                return `
                    <h4 class="mb-4">⚙️ Proses Instalasi</h4>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        Semua konfigurasi sudah siap. Klik tombol "Mulai Instalasi" untuk memulai proses instalasi.
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-primary btn-lg" onclick="wizard.startInstallation()">
                            <i class="fas fa-play me-2"></i>Mulai Instalasi
                        </button>
                    </div>
                `;
            }

            getStep5Content() {
                return `
                    <h4 class="mb-4">🧪 Testing & Validasi</h4>
                    <div id="installation-progress">
                        <!-- Installation progress will be shown here -->
                    </div>
                `;
            }

            getStep6Content() {
                return `
                    <h4 class="mb-4">✅ Instalasi Selesai</h4>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        Instalasi SISKA berhasil diselesaikan!
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Informasi Login Admin</h6>
                            <p class="card-text">
                                <strong>Username:</strong> admin<br>
                                <strong>Password:</strong> admin123
                            </p>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Penting:</strong> Ganti password default setelah login pertama kali!
                            </div>
                        </div>
                    </div>
                `;
            }

            async nextStep() {
                if (this.currentStep < this.totalSteps) {
                    // Validate current step
                    if (await this.validateCurrentStep()) {
                        this.currentStep++;
                        this.loadStepContent(this.currentStep);
                    }
                }
            }

            prevStep() {
                if (this.currentStep > 1) {
                    this.currentStep--;
                    this.loadStepContent(this.currentStep);
                }
            }

            async validateCurrentStep() {
                switch(this.currentStep) {
                    case 1:
                        return await this.validateStep1();
                    case 2:
                        return await this.validateStep2();
                    case 3:
                        return await this.validateStep3();
                    default:
                        return true;
                }
            }

            async validateStep1() {
                const form = document.getElementById('form-step-1');
                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());

                try {
                    this.showLoading('Memvalidasi informasi...');
                    const response = await axios.post('/installer/api/validate-license-school', data);
                    this.hideLoading();
                    this.showAlert('success', response.data.message);
                    return true;
                } catch (error) {
                    this.hideLoading();
                    this.showAlert('error', error.response?.data?.message || 'Validasi gagal');
                    return false;
                }
            }

            async validateStep2() {
                const selectedJenjang = Array.from(document.querySelectorAll('input[name="selected_jenjang[]"]:checked'))
                    .map(input => input.value);

                if (selectedJenjang.length === 0) {
                    this.showAlert('error', 'Pilih minimal satu jenjang');
                    return false;
                }

                try {
                    this.showLoading('Memvalidasi pilihan jenjang...');
                    const response = await axios.post('/installer/api/validate-jenjang-selection', {
                        selected_jenjang: selectedJenjang
                    });
                    this.hideLoading();
                    this.showAlert('success', response.data.message);
                    return true;
                } catch (error) {
                    this.hideLoading();
                    this.showAlert('error', error.response?.data?.message || 'Validasi gagal');
                    return false;
                }
            }

            async validateStep3() {
                const form = document.getElementById('form-step-3');
                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());

                try {
                    this.showLoading('Menguji koneksi database...');
                    const response = await axios.post('/installer/api/validate-database-config', data);
                    this.hideLoading();
                    this.showAlert('success', response.data.message);
                    return true;
                } catch (error) {
                    this.hideLoading();
                    this.showAlert('error', error.response?.data?.message || 'Koneksi database gagal');
                    return false;
                }
            }

            async loadAvailableJenjang() {
                try {
                    const response = await axios.get('/installer/api/available-jenjang');
                    const jenjang = response.data.data;
                    
                    const container = document.getElementById('jenjang-options');
                    container.innerHTML = jenjang.map(j => `
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="selected_jenjang[]" value="${j}" id="jenjang-${j}">
                            <label class="form-check-label" for="jenjang-${j}">
                                <strong>${j.toUpperCase()}</strong> - ${this.getJenjangDescription(j)}
                            </label>
                        </div>
                    `).join('');
                } catch (error) {
                    console.error('Error loading jenjang:', error);
                }
            }

            getJenjangDescription(jenjang) {
                const descriptions = {
                    'sd': 'Sekolah Dasar - Manajemen siswa SD dengan kredit poin dan penilaian karakter',
                    'smp': 'Sekolah Menengah Pertama - Manajemen siswa SMP dengan ekstrakurikuler',
                    'sma': 'Sekolah Menengah Atas - Manajemen siswa SMA dengan organisasi',
                    'smk': 'Sekolah Menengah Kejuruan - Manajemen siswa SMK dengan kejuruan'
                };
                return descriptions[jenjang] || 'Jenjang pendidikan';
            }

            async startInstallation() {
                try {
                    this.showLoading('Memulai instalasi...');
                    const response = await axios.post('/installer/api/start-installation');
                    this.hideLoading();
                    
                    // Move to step 5
                    this.currentStep = 5;
                    this.loadStepContent(5);
                    
                    // Start monitoring progress
                    this.monitorInstallationProgress();
                } catch (error) {
                    this.hideLoading();
                    this.showAlert('error', error.response?.data?.message || 'Gagal memulai instalasi');
                }
            }

            async monitorInstallationProgress() {
                const interval = setInterval(async () => {
                    try {
                        const response = await axios.get('/installer/api/installation-progress');
                        const progress = response.data.data;
                        
                        this.updateProgress(progress.percentage, progress.message);
                        
                        if (progress.status === 'completed') {
                            clearInterval(interval);
                            this.currentStep = 6;
                            this.loadStepContent(6);
                        }
                    } catch (error) {
                        console.error('Error monitoring progress:', error);
                    }
                }, 2000);
            }

            async completeInstallation() {
                try {
                    this.showLoading('Menyelesaikan instalasi...');
                    const response = await axios.post('/installer/api/complete-installation');
                    this.hideLoading();
                    
                    // Redirect to login
                    window.location.href = '/login';
                } catch (error) {
                    this.hideLoading();
                    this.showAlert('error', error.response?.data?.message || 'Gagal menyelesaikan instalasi');
                }
            }

            updateStepStatus(stepNumber) {
                this.steps.forEach((step, index) => {
                    step.active = step.id === stepNumber;
                    step.completed = step.id < stepNumber;
                });
                this.renderSteps();
            }

            updateButtons(stepNumber) {
                const btnPrev = document.getElementById('btn-prev');
                const btnNext = document.getElementById('btn-next');
                const btnComplete = document.getElementById('btn-complete');

                btnPrev.style.display = stepNumber > 1 ? 'block' : 'none';
                btnNext.style.display = stepNumber < this.totalSteps ? 'block' : 'none';
                btnComplete.style.display = stepNumber === this.totalSteps ? 'block' : 'none';
            }

            updateProgress(percentage, message) {
                const progressBar = document.getElementById('progress-bar');
                const progressText = document.getElementById('progress-text');
                
                progressBar.style.width = percentage + '%';
                progressText.textContent = `${percentage}% - ${message}`;
            }

            showLoading(title = 'Memproses...', message = 'Mohon tunggu sebentar') {
                document.getElementById('loading-title').textContent = title;
                document.getElementById('loading-message').textContent = message;
                new bootstrap.Modal(document.getElementById('loadingModal')).show();
            }

            hideLoading() {
                const modal = bootstrap.Modal.getInstance(document.getElementById('loadingModal'));
                if (modal) modal.hide();
            }

            showAlert(type, message) {
                const alertClass = type === 'error' ? 'alert-danger' : 'alert-success';
                const alert = document.createElement('div');
                alert.className = `alert ${alertClass} alert-dismissible fade show`;
                alert.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                
                const content = document.getElementById('step-content');
                content.insertBefore(alert, content.firstChild);
                
                // Auto dismiss after 5 seconds
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 5000);
            }
        }

        // Initialize wizard
        const wizard = new WizardInstaller();
    </script>
</body>
</html>


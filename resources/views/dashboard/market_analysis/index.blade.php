<x-app-dashboard>
    <div class="py-12 bg-gray-50 min-h-screen" x-data="marketAnalysisWizard()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 flex justify-between items-end">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Market Intelligence Hub</h1>
                    <p class="mt-2 text-lg text-gray-600">Premium AI-powered research and competitive analysis.</p>
                </div>
                <div class="flex space-x-3">
                    <button @click="resetWizard()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        New Analysis
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content (Wizard or Result) -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Wizard Area -->
                    <template x-if="!showResult">
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 transition-all duration-500">
                            <!-- Stepper -->
                            <div class="px-8 py-6 bg-gray-50/50 border-b border-gray-100">
                                <nav aria-label="Progress">
                                    <ol role="list" class="flex items-center">
                                        <template x-for="(stepName, index) in steps" :key="index">
                                            <li :class="[index !== steps.length - 1 ? 'flex-1' : '', 'relative']">
                                                <div class="flex items-center">
                                                    <div :class="[
                                                        currentStep > index + 1 ? 'bg-primary-600' : 
                                                        currentStep === index + 1 ? 'border-2 border-primary-600 bg-white' : 
                                                        'border-2 border-gray-300 bg-white',
                                                        'h-10 w-10 rounded-full flex items-center justify-center transition-all duration-300 z-10'
                                                    ]">
                                                        <template x-if="currentStep > index + 1">
                                                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                        </template>
                                                        <template x-if="currentStep <= index + 1">
                                                            <span :class="currentStep === index + 1 ? 'text-primary-600 font-bold' : 'text-gray-500 font-medium'" x-text="index + 1"></span>
                                                        </template>
                                                    </div>
                                                    <!-- Line -->
                                                    <template x-if="index !== steps.length - 1">
                                                        <div class="hidden sm:block absolute top-5 left-10 w-full h-0.5" :class="currentStep > index + 1 ? 'bg-primary-600' : 'bg-gray-200'"></div>
                                                    </template>
                                                </div>
                                                <div class="mt-3">
                                                    <span class="text-xs font-semibold tracking-wide uppercase" :class="currentStep >= index + 1 ? 'text-primary-600' : 'text-gray-500'" x-text="stepName"></span>
                                                </div>
                                            </li>
                                        </template>
                                    </ol>
                                </nav>
                            </div>

                            <!-- Step Content -->
                            <div class="p-8 min-h-[400px]">
                                <!-- Step 1: Target Selection -->
                                <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
                                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Select Target Product</h2>
                                    <p class="text-gray-600 mb-8">What product or business area would you like to analyze today?</p>
                                    
                                    <div class="space-y-4">
                                        <label class="block text-sm font-medium text-gray-700">Audience Configuration</label>
                                        <select x-model="formData.product_id" class="block w-full px-4 py-4 rounded-xl border-gray-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-lg transition-all hover:border-primary-300">
                                            <option value="">-- Choose a Product --</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                        <p class="text-sm text-gray-500 mt-2 italic">You can manage these in the Audience Configuration section.</p>
                                    </div>
                                </div>

                                <!-- Step 2: Research Type -->
                                <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
                                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Choose Research Strategy</h2>
                                    <p class="text-gray-600 mb-8">Select the depth of analysis you need for this session.</p>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <!-- Consumer -->
                                        <div @click="formData.research_type = 'consumer'" :class="formData.research_type === 'consumer' ? 'border-primary-500 ring-4 ring-primary-50 bg-primary-50/30' : 'border-gray-200 hover:border-primary-200'" class="relative p-6 border-2 rounded-2xl cursor-pointer transition-all duration-200 group">
                                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4 text-blue-600">
                                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 005.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                            </div>
                                            <h3 class="font-bold text-gray-900 group-hover:text-primary-600 transition-colors">Consumer Insight</h3>
                                            <p class="text-xs text-gray-500 mt-2">Behavioral patterns, pain points, and target demographics.</p>
                                        </div>
                                        <!-- Competitor -->
                                        <div @click="formData.research_type = 'competitor'" :class="formData.research_type === 'competitor' ? 'border-primary-500 ring-4 ring-primary-50 bg-primary-50/30' : 'border-gray-200 hover:border-primary-200'" class="relative p-6 border-2 rounded-2xl cursor-pointer transition-all duration-200 group">
                                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mb-4 text-red-600">
                                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                            </div>
                                            <h3 class="font-bold text-gray-900 group-hover:text-primary-600 transition-colors">Competitor Map</h3>
                                            <p class="text-xs text-gray-500 mt-2">Strategic benchmarking and market positioning analysis.</p>
                                        </div>
                                        <!-- Trend -->
                                        <div @click="formData.research_type = 'trend'" :class="formData.research_type === 'trend' ? 'border-primary-500 ring-4 ring-primary-50 bg-primary-50/30' : 'border-gray-200 hover:border-primary-200'" class="relative p-6 border-2 rounded-2xl cursor-pointer transition-all duration-200 group">
                                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4 text-green-600">
                                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                            </div>
                                            <h3 class="font-bold text-gray-900 group-hover:text-primary-600 transition-colors">Trend Pulse</h3>
                                            <p class="text-xs text-gray-500 mt-2">Market growth index and emerging industry trends.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 3: Parameters -->
                                <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
                                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Configure Parameters</h2>
                                    <p class="text-gray-600 mb-8">Fine-tune the analysis timeframe for precise results.</p>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                        <div class="space-y-2">
                                            <label class="block text-sm font-medium text-gray-700">Start Date</label>
                                            <input type="date" x-model="formData.start_date" class="block w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="block text-sm font-medium text-gray-700">End Date</label>
                                            <input type="date" x-model="formData.end_date" class="block w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                        </div>
                                    </div>
                                    
                                    <div class="mt-8 flex flex-wrap gap-2">
                                        <button @click="setRange(30)" type="button" class="px-4 py-2 rounded-full border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:border-primary-300 transition-all">Last 30 Days</button>
                                        <button @click="setRange(90)" type="button" class="px-4 py-2 rounded-full border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:border-primary-300 transition-all">Last 3 Months</button>
                                        <button @click="setRange(180)" type="button" class="px-4 py-2 rounded-full border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:border-primary-300 transition-all">Last 6 Months</button>
                                    </div>
                                </div>

                                <!-- Step 4: Execution -->
                                <div x-show="currentStep === 4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                                    <div class="text-center py-10" x-show="!isAnalyzing">
                                        <div class="w-24 h-24 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-6 text-primary-600">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                        </div>
                                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Ready to Launch</h2>
                                        <p class="text-gray-600 mb-8 max-w-sm mx-auto">Confirm your settings and start the high-performance AI market analysis engine.</p>
                                        
                                        <div class="inline-block text-left bg-gray-50 p-6 rounded-2xl border border-gray-200 w-full max-w-md mx-auto mb-8">
                                            <div class="flex justify-between mb-2">
                                                <span class="text-sm text-gray-500">Target Product:</span>
                                                <span class="text-sm font-bold text-gray-900" x-text="getSelectedProductName()"></span>
                                            </div>
                                            <div class="flex justify-between mb-2">
                                                <span class="text-sm text-gray-500">Strategy:</span>
                                                <span class="text-sm font-bold text-gray-900 capitalize" x-text="formData.research_type"></span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-500">Timeline:</span>
                                                <span class="text-sm font-bold text-gray-900" x-text="`${formData.start_date} → ${formData.end_date}`"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Analyzing State -->
                                    <div class="text-center py-10" x-show="isAnalyzing">
                                        <div class="relative w-32 h-32 mx-auto mb-8">
                                            <div class="absolute inset-0 rounded-full border-4 border-primary-100"></div>
                                            <div class="absolute inset-0 rounded-full border-4 border-primary-600 border-t-transparent animate-spin"></div>
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-primary-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                            </div>
                                        </div>
                                        <h2 class="text-2xl font-bold text-gray-900 mb-2" x-text="analysisStatus">Processing Market Data</h2>
                                        <div class="max-w-xs mx-auto overflow-hidden h-2 mb-4 text-xs flex rounded bg-primary-100">
                                            <div :style="`width: ${analysisProgress}%`" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-primary-600 transition-all duration-1000"></div>
                                        </div>
                                        <p class="text-gray-500 text-sm italic" x-text="statusSubtext">Harnessing advanced intelligence networks...</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Actions -->
                            <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100 flex justify-between items-center" x-show="!isAnalyzing">
                                <button type="button" @click="prevStep()" x-show="currentStep > 1" class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-white hover:border-gray-400 transition-all">Back</button>
                                <div x-show="currentStep === 1"></div>  <!-- Spacer -->
                                
                                <button type="button" @click="nextStep()" :disabled="!isStepReady()" :class="!isStepReady() ? 'opacity-50 cursor-not-allowed' : 'hover:scale-105 shadow-lg'" class="px-8 py-3 bg-primary-600 text-white rounded-xl font-bold transition-all">
                                    <span x-text="currentStep === 4 ? 'Launch Research Engine' : 'Continue'"></span>
                                </button>
                            </div>
                        </div>
                    </template>

                    <!-- Analysis View Container -->
                    <div id="analysis-result-container" x-show="showResult" class="animate-fade-in">
                        <!-- Content loaded via AJAX -->
                    </div>
                </div>

                <!-- History Sidebar -->
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 bg-gray-50/50 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="font-bold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Recent Intel
                            </h3>
                            <span class="text-xs font-bold text-gray-400 uppercase">{{ $analyses->count() }} Reports</span>
                        </div>
                        
                        <div class="overflow-y-auto max-h-[800px] divide-y divide-gray-100 custom-scrollbar">
                           @forelse($analyses as $analysis)
                                <div class="group p-5 hover:bg-gray-50 cursor-pointer transition-all border-l-4 border-transparent hover:border-primary-500" onclick="viewAnalysis({{ $analysis->id }})">
                                    <div class="flex justify-between items-start mb-2">
                                        <span @class([
                                            'px-2 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-widest',
                                            'bg-blue-100 text-blue-700' => $analysis->research_type === 'consumer',
                                            'bg-red-100 text-red-700' => $analysis->research_type === 'competitor',
                                            'bg-green-100 text-green-700' => $analysis->research_type === 'trend',
                                        ])>
                                            {{ $analysis->research_type }}
                                        </span>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">{{ $analysis->created_at->diffForHumans() }}</span>
                                    </div>
                                    <h4 class="text-sm font-bold text-gray-900 group-hover:text-primary-600 transition-colors truncate">{{ $analysis->title }}</h4>
                                    <p class="text-xs text-gray-500 mt-2 line-clamp-2">{{ $analysis->summary }}</p>
                                </div>
                           @empty
                                <div class="p-10 text-center">
                                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                    </div>
                                    <p class="text-sm font-bold text-gray-400 uppercase tracking-tighter">No Reports Yet</p>
                                </div>
                           @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripting for Wizard 2.0 -->
    <script>
        function marketAnalysisWizard() {
            return {
                currentStep: 1,
                steps: ['Audience', 'Strategy', 'Timeframe', 'Confirm'],
                showResult: false,
                isAnalyzing: false,
                analysisProgress: 0,
                analysisStatus: 'Initializing Agent...',
                statusSubtext: 'Establishing neural connection...',
                formData: {
                    product_id: '',
                    research_type: '',
                    start_date: '{{ date('Y-m-d', strtotime('-30 days')) }}',
                    end_date: '{{ date('Y-m-d') }}'
                },
                
                nextStep() {
                    if (this.currentStep < 4) {
                        this.currentStep++;
                    } else {
                        this.startAnalysis();
                    }
                },
                
                prevStep() {
                    if (this.currentStep > 1) this.currentStep--;
                },
                
                isStepReady() {
                    if (this.currentStep === 1) return this.formData.product_id !== '';
                    if (this.currentStep === 2) return this.formData.research_type !== '';
                    return true;
                },
                
                getSelectedProductName() {
                    const select = document.querySelector('select[x-model="formData.product_id"]');
                    if (select && select.selectedIndex > 0) {
                        return select.options[select.selectedIndex].text;
                    }
                    return 'Not selected';
                },
                
                setRange(days) {
                    const end = new Date();
                    const start = new Date();
                    start.setDate(end.getDate() - days);
                    this.formData.start_date = start.toISOString().split('T')[0];
                    this.formData.end_date = end.toISOString().split('T')[0];
                },
                
                resetWizard() {
                    this.showResult = false;
                    this.currentStep = 1;
                    this.isAnalyzing = false;
                    this.analysisProgress = 0;
                },
                
                startAnalysis() {
                    this.isAnalyzing = true;
                    this.analysisProgress = 0;
                    
                    // Simulate progress steps
                    const statuses = [
                        { p: 15, s: 'Crawling Web Data...', sub: 'Searching Google, Trends and Shopping networks...' },
                        { p: 40, s: 'Competitor Benchmarking...', sub: 'Analyzing URLs and market positioning...' },
                        { p: 65, s: 'AI Pattern Recognition...', sub: 'Processing insights through Gemini Pro...' },
                        { p: 85, s: 'Constructing Intelligence Report...', sub: 'Finalizing visualizations and strategic advice...' },
                        { p: 100, s: 'Analysis Complete!', sub: 'Optimizing viewing experience...' }
                    ];
                    
                    let statusIdx = 0;
                    const interval = setInterval(() => {
                        if (statusIdx < statuses.length) {
                            this.analysisProgress = statuses[statusIdx].p;
                            this.analysisStatus = statuses[statusIdx].s;
                            this.statusSubtext = statuses[statusIdx].sub;
                            statusIdx++;
                        }
                    }, 2500);

                    // Actual Request
                    fetch('{{ route('dashboard.market_analysis.analyze') }}', {
                        method: 'POST',
                        body: JSON.stringify(this.formData),
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            clearInterval(interval);
                            this.analysisProgress = 100;
                            setTimeout(() => {
                                this.showResult = true;
                                this.isAnalyzing = false;
                                this.renderResults(data);
                            }, 500);
                        } else {
                            alert('Analysis failed: ' + (data.message || 'Unknown error'));
                            this.isAnalyzing = false;
                            clearInterval(interval);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.isAnalyzing = false;
                        clearInterval(interval);
                    });
                },
                
                renderResults(data) {
                    const type = data.type;
                    const resultData = data.data;
                    
                    // Here we will use fetch to a new endpoint or just build the dynamic HTML
                    // For now, let's assume we have specialized components
                    document.getElementById('analysis-result-container').innerHTML = `
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                             <div class="px-8 py-6 bg-gradient-to-r from-primary-600 to-primary-700 text-white flex justify-between items-center">
                                <div>
                                    <h2 class="text-2xl font-bold font-display">Intelligence Report: ${type.toUpperCase()}</h2>
                                    <p class="text-primary-100 text-sm opacity-90">Analysis Period: ${this.formData.start_date} to ${this.formData.end_date}</p>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="/dashboard/market_analysis/export/pdf" class="bg-white/10 hover:bg-white/20 p-2 rounded-lg transition-all" title="Export PDF">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414l-5-5H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd"></path></svg>
                                    </a>
                                </div>
                             </div>
                             <div class="p-8" id="result-dynamic-content">
                                <!-- Dynamic component loading base on type -->
                                <div class="animate-pulse flex flex-col space-y-4">
                                    <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                    <div class="h-4 bg-gray-200 rounded"></div>
                                    <div class="h-4 bg-gray-200 rounded w-5/6"></div>
                                </div>
                             </div>
                        </div>
                    `;
                    
                    // Actually call a partial view renderer
                    fetch(`/dashboard/market_analysis/render-partial/${type}?data=${encodeURIComponent(JSON.stringify(resultData))}`)
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('result-dynamic-content').innerHTML = html;
                    });
                }
            }
        }

        function viewAnalysis(id) {
            window.location.href = `/dashboard/market_analysis/${id}`;
        }
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; height: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(156, 163, 175, 0.2); border-radius: 2px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(156, 163, 175, 0.4); }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .font-display { font-family: 'Outfit', 'Inter', system-ui, sans-serif; }
    </style>
</x-app-dashboard>

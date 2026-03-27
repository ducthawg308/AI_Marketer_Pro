<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market Intelligence Report - {{ $product->name }}</title>
    <style>
        @page {
            margin: 0.5in;
            size: A4;
        }
        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.6;
            color: #1f2937;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: left;
            border-bottom: 4px solid #4f46e5;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #4f46e5;
            font-size: 28pt;
            margin: 0;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: -1px;
        }
        .header .subtitle {
            color: #6b7280;
            font-size: 12pt;
            margin: 5px 0 0 0;
            font-weight: bold;
        }
        .product-info {
            background-color: #f3f4f6;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
        }
        .product-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .product-info td {
            padding: 5px 0;
            vertical-align: top;
        }
        .label {
            font-weight: bold;
            color: #4b5563;
            width: 150px;
            text-transform: uppercase;
            font-size: 9pt;
        }
        .section {
            margin-bottom: 40px;
            page-break-inside: avoid;
        }
        .section h2 {
            color: #111827;
            font-size: 18pt;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-weight: 800;
        }
        .card {
            background-color: #f9fafb;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 15px;
            border: 1px solid #f3f4f6;
        }
        .card h3 {
            margin-top: 0;
            color: #4f46e5;
            font-size: 14pt;
        }
        .grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 15px;
            margin-left: -15px;
            margin-right: -15px;
        }
        .grid td {
            width: 50%;
            vertical-align: top;
            background-color: #f9fafb;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #f3f4f6;
        }
        .swot-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px;
        }
        .swot-cell {
            width: 50%;
            padding: 15px;
            border-radius: 10px;
            vertical-align: top;
        }
        .strengths { background-color: #ecfdf5; border-left: 5px solid #10b981; }
        .weaknesses { background-color: #fef2f2; border-left: 5px solid #ef4444; }
        .opportunities { background-color: #eff6ff; border-left: 5px solid #3b82f6; }
        .threats { background-color: #fff7ed; border-left: 5px solid #f97316; }
        
        .persona-badge {
            display: inline-block;
            background-color: #4f46e5;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 10pt;
            margin-bottom: 10px;
        }
        .footer {
            margin-top: 50px;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
            text-align: center;
            font-size: 9pt;
            color: #9ca3af;
        }
        .list-item {
            margin-bottom: 8px;
            position: relative;
            padding-left: 20px;
        }
        .list-item:before {
            content: "•";
            color: #4f46e5;
            font-weight: bold;
            position: absolute;
            left: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Intelligence Report</h1>
        <p class="subtitle">{{ strtoupper($analysisType) }} ANALYSIS • AI MARKETER PRO</p>
    </div>

    <div class="product-info">
        <table>
            <tr>
                <td class="label">Product Name</td>
                <td><strong>{{ $product->name }}</strong></td>
            </tr>
            <tr>
                <td class="label">Industry</td>
                <td>{{ $product->industry }}</td>
            </tr>
            <tr>
                <td class="label">Analysis Type</td>
                <td>{{ ucfirst($analysisType) }}</td>
            </tr>
            <tr>
                <td class="label">Date Generated</td>
                <td>{{ $generatedAt }}</td>
            </tr>
        </table>
    </div>

    <!-- 1. CONSUMER ANALYSIS -->
    @if($analysisType === 'consumer')
        <div class="section">
            <h2>TARGET PERSONA PROFILE</h2>
            <div class="card" style="background-color: #eef2ff; border-left: 8px solid #4f46e5;">
                <div class="persona-badge">{{ $data['persona'] ?? 'Primary Target' }}</div>
                <p style="font-size: 14pt; font-weight: bold; color: #1e1b4b; margin-top: 10px;">
                    "{{ $data['summary'] ?? 'Strategic target segment analysis' }}"
                </p>
                <div style="margin-top: 20px;">
                    <span style="margin-right: 20px;"><strong>Age:</strong> {{ $data['age_range'] ?? 'N/A' }}</span>
                    <span style="margin-right: 20px;"><strong>Income:</strong> {{ $data['income'] ?? 'N/A' }}</span>
                    <span><strong>Location:</strong> {{ $data['location'] ?? 'N/A' }}</span>
                </div>
            </div>

            <table class="grid">
                <tr>
                    <td>
                        <h3 style="color: #ef4444;">Core Pain Points</h3>
                        @foreach($data['pain_points'] ?? [] as $p)
                            <div class="list-item">{{ $p }}</div>
                        @endforeach
                    </td>
                    <td>
                        <h3 style="color: #10b981;">Key Desires</h3>
                        @foreach($data['desires'] ?? [] as $d)
                            <div class="list-item">{{ $d }}</div>
                        @endforeach
                    </td>
                </tr>
            </table>

            @if(isset($data['empathy_map']))
                <h3>Mindset & Behavior (Empathy Map)</h3>
                <div class="card">
                    <p><strong>Thoughts & Feelings:</strong> {{ $data['empathy_map']['thinks_feels'] ?? 'N/A' }}</p>
                    <p><strong>Market Perceptions:</strong> {{ $data['empathy_map']['sees_hears'] ?? 'N/A' }}</p>
                    <p><strong>Actions & Social Presence:</strong> {{ $data['empathy_map']['says_does'] ?? 'N/A' }}</p>
                    <p><strong>Success Drivers:</strong> {{ $data['empathy_map']['pains_gains'] ?? 'N/A' }}</p>
                </div>
            @endif
        </div>
    @endif

    <!-- 2. COMPETITOR ANALYSIS -->
    @if($analysisType === 'competitor')
        <div class="section">
            <h2>MARKET COMPETITION MAP</h2>
            @foreach($data['competitors'] ?? [] as $competitor)
                <div class="card">
                    <h3 style="margin-bottom: 5px;">{{ $competitor['name'] }}</h3>
                    <p style="color: #4f46e5; font-size: 10pt; font-weight: bold; margin-bottom: 15px;">{{ $competitor['url'] ?? '' }}</p>
                    
                    <div style="margin-top: 10px;">
                        <p><strong>Strengths:</strong> {{ is_array($competitor['strengths']) ? implode(', ', $competitor['strengths']) : $competitor['strengths'] }}</p>
                        <p><strong>Vulnerabilities:</strong> {{ is_array($competitor['weaknesses']) ? implode(', ', $competitor['weaknesses']) : $competitor['weaknesses'] }}</p>
                    </div>
                </div>
            @endforeach

            <h2>STRATEGIC CONQUEST PLAN</h2>
            @foreach($data['strategy'] ?? [] as $s)
                <div class="card" style="border-left: 5px solid #4f46e5;">
                    <h4 style="margin: 0 0 10px 0; color: #1e1b4b;">{{ $s['title'] }}</h4>
                    <p style="margin: 0; font-size: 10pt;">{{ $s['content'] }}</p>
                </div>
            @endforeach
        </div>
    @endif

    <!-- 3. TREND ANALYSIS -->
    @if($analysisType === 'trend')
        <div class="section">
            <h2>MARKET DYNAMICS OVERVIEW</h2>
            <div style="display: table; width: 100%; margin-bottom: 30px;">
                <div style="display: table-cell; width: 50%; padding-right: 15px;">
                    <div class="card" style="background-color: #eff6ff; text-align: center;">
                        <p style="text-transform: uppercase; font-size: 8pt; font-weight: bold; color: #3b82f6;">Estimated Market Size</p>
                        <p style="font-size: 20pt; font-weight: 900; color: #1e3a8a; margin: 5px 0;">{{ $data['market_size'] ?? 'N/A' }}</p>
                    </div>
                </div>
                <div style="display: table-cell; width: 50%; padding-left: 15px;">
                    <div class="card" style="background-color: #ecfdf5; text-align: center;">
                        <p style="text-transform: uppercase; font-size: 8pt; font-weight: bold; color: #10b981;">Projected Growth</p>
                        <p style="font-size: 20pt; font-weight: 900; color: #064e3b; margin: 5px 0;">{{ $data['growth_rate'] ?? '0%' }}</p>
                    </div>
                </div>
            </div>

            <h3>Core Analysis</h3>
            <p style="font-style: italic; color: #4b5563; line-height: 1.8;">
                {{ $data['analysis'] ?? 'Detailed market trend analysis report...' }}
            </p>

            <h2>EMERGING TRENDS</h2>
            @foreach($data['emerging_trends'] ?? [] as $trend)
                <div class="card">
                    <div style="float: right;">
                        <span style="background-color: #f3f4f6; padding: 2px 10px; border-radius: 10px; font-size: 8pt; font-weight: bold;">
                            {{ $trend['impact_level'] ?? 'Normal' }} Impact
                        </span>
                    </div>
                    <h4 style="margin: 0 0 10px 0;">{{ $trend['trend'] }}</h4>
                    <p style="margin: 0; font-size: 10pt; color: #4b5563;">{{ $trend['description'] }}</p>
                    <p style="margin-top: 10px; font-size: 9pt; font-weight: bold; color: #4f46e5;">Timeline: {{ $trend['timeline'] ?? 'Upcoming' }}</p>
                </div>
            @endforeach

            @if(isset($data['swot_analysis']))
                <div style="page-break-before: always;"></div>
                <h2>INDUSTRY SWOT ANALYSIS</h2>
                <table class="swot-table">
                    <tr>
                        <td class="swot-cell strengths">
                            <h4 style="margin: 0 0 10px 0; color: #065f46;">Strengths</h4>
                            @foreach($data['swot_analysis']['strengths'] ?? [] as $s)
                                <div style="font-size: 9pt; margin-bottom: 5px;">• {{ $s }}</div>
                            @endforeach
                        </td>
                        <td class="swot-cell weaknesses">
                            <h4 style="margin: 0 0 10px 0; color: #991b1b;">Weaknesses</h4>
                            @foreach($data['swot_analysis']['weaknesses'] ?? [] as $w)
                                <div style="font-size: 9pt; margin-bottom: 5px;">• {{ $w }}</div>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td class="swot-cell opportunities">
                            <h4 style="margin: 0 0 10px 0; color: #1e40af;">Opportunities</h4>
                            @foreach($data['swot_analysis']['opportunities'] ?? [] as $o)
                                <div style="font-size: 9pt; margin-bottom: 5px;">• {{ $o }}</div>
                            @endforeach
                        </td>
                        <td class="swot-cell threats">
                            <h4 style="margin: 0 0 10px 0; color: #854d0e;">Threats</h4>
                            @foreach($data['swot_analysis']['threats'] ?? [] as $t)
                                <div style="font-size: 9pt; margin-bottom: 5px;">• {{ $t }}</div>
                            @endforeach
                        </td>
                    </tr>
                </table>
            @endif
        </div>
    @endif

    <div class="footer">
        <p>© 2026 AI MARKETER PRO - CONFIDENTIAL STRATEGIC INTELLIGENCE</p>
    </div>
</body>
</html>

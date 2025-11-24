# AI Market Forecasting Python Scripts

This folder contains Python scripts for AI-driven market analysis and forecasting in the Laravel application.

## Setup

### 1. Install Dependencies

Navigate to the python_scripts directory and install the required packages:

```bash
cd python_scripts
pip install -r requirements.txt
```

Or install individually:
```bash
pip install pandas>=2.0.0 numpy>=1.24.0 scikit-learn>=1.3.0 prophet>=1.1.0
```

### 2. Requirements

- **pandas**: Data manipulation and analysis
- **numpy**: Numerical computing
- **scikit-learn**: Machine learning algorithms
- **prophet**: Time series forecasting (Facebook Prophet)

## Scripts

### forecast.py

**Purpose**: Main forecasting script that handles time-series predictions using multiple fallback methods.

**Usage**:
```bash
python forecast.py input.json
```

**Input Format**:
```json
{
  "data": [
    {"ds": "2024-01-01", "y": 80},
    {"ds": "2024-02-01", "y": 85}
  ],
  "periods": 3
}
```

**Fallback Chain**:
1. **Prophet** (primary) - Facebook Prophet for robust time-series forecasting
2. **Linear Regression** - Fallback for trends without seasonality
3. **Simple Extrapolation** - Basic growth projection
4. **Baseline Fallback** - Random plausible values when no data

**Output Format**:
```json
{
  "dates": ["2024-04-01", "2024-05-01", "2024-06-01"],
  "predicted_values": [88.5, 92.1, 95.7],
  "lower_bounds": [80.0, 85.0, 88.0],
  "upper_bounds": [95.0, 98.0, 102.0],
  "growth_trend": 0.124,
  "seasonal_index": 1.05,
  "method": "prophet"
}
```

## Laravel Integration

The scripts are called from `App\Services\Dashboard\MarketAnalysis\PredictiveAnalyticsService` which:

1. Prepares input data from crawled sources (Google Trends, Reddit, etc.)
2. Calls the Python scripts via Symfony Process
3. Handles errors and fallbacks gracefully
4. Caches results in Redis for performance

## Troubleshooting

### Prophet Import Issues
If you encounter asyncio errors on Windows:
- The script has automatic fallbacks to sklearn methods
- Consider downgrading Python version or using WSL

### Performance
- Results are cached for 30 minutes in Laravel's cache
- For heavy usage, consider setting up a dedicated Python service

### Dependencies
- Make sure all packages are installed in the same Python environment
- Use virtual environments to avoid conflicts

## File Structure
```
python_scripts/
├── README.md          # This documentation
├── forecast.py        # Main forecasting script
└── requirements.txt   # Python dependencies

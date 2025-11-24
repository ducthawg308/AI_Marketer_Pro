# AI Marketer Pro - Laravel Application

A comprehensive marketing analytics platform built with Laravel and AI-driven insights.

## Features

- **Market Analysis**: Real-time market research and trend analysis
- **AI-Powered Forecasting**: Predictive analytics using machine learning
- **Social Media Analytics**: Integration with multiple data sources
- **Automated Reporting**: PDF and Word export capabilities

## AI Predictive Analytics

### New Features Added

The system now includes AI-driven predictive analytics that provide:

1. **Smart Forecasting**: 2-3 month market trend predictions using Facebook Prophet
2. **Opportunity Scoring**: Age-group specific opportunity analysis
3. **Action Recommendations**: Automated strategic recommendations based on predictions
4. **Real-time Caching**: Redis-powered performance optimization

### Technical Implementation

- **Python Integration**: External Python scripts in `/python_scripts/` folder
- **Fallback Mechanisms**: Multiple ML methods (Prophet → Linear Regression → Baseline)
- **Laravel Services**: Clean separation with Dependency Injection
- **Error Handling**: Graceful degradation when ML libraries fail

## Installation

### Prerequisites

1. **PHP 8.2+** with required extensions
2. **Composer** for PHP dependency management
3. **Node.js** for frontend assets
4. **Python 3.8+** for AI analytics (optional but recommended)

### Setup Steps

1. **Clone and Install PHP Dependencies:**
   ```bash
   git clone <repository-url>
   cd ai_marketer_pro
   composer install
   ```

2. **Environment Configuration:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   # Configure your database and other settings
   ```

3. **Database Setup:**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

4. **Python AI Dependencies (Optional but Recommended):**
   ```bash
   cd python_scripts
   pip install -r requirements.txt
   cd ..
   ```

5. **Frontend Assets:**
   ```bash
   npm install
   npm run build
   ```

6. **Redis Setup (Recommended):**
   ```bash
   # Install and start Redis server
   composer require predis/predis
   ```

## Project Structure

```
ai_marketer_pro/
├── app/
│   ├── Services/
│   │   └── Dashboard/
│   │       └── MarketAnalysis/
│   │           ├── MarketAnalysisService.php
│   │           └── PredictiveAnalyticsService.php  # AI Forecasting
├── python_scripts/                              # AI/ML Scripts
│   ├── forecast.py                               # Main forecasting script
│   ├── requirements.txt                          # Python dependencies
│   └── README.md                                 # Setup guide
├── resources/views/dashboard/market_analysis/
├── routes/
├── tests/
└── README.md
```

## Python AI Module

The AI predictive analytics is powered by Python scripts that provide:

- **Prophet Forecasting**: Advanced time-series analysis
- **Fallback Systems**: Multiple algorithms for reliability
- **Laravel Integration**: Seamlessly called from PHP services

### Python Dependencies

- `pandas` - Data manipulation
- `numpy` - Scientific computing
- `scikit-learn` - Machine learning
- `prophet` - Time series forecasting

### Usage

The Python scripts are automatically called by Laravel services. No manual intervention required.

## API Documentation

### Market Analysis Endpoints

- `POST /dashboard/market-analysis/analyze` - Perform market analysis
- `GET /dashboard/market-analysis/export/{type}` - Export reports (PDF/Word)

### AI-Powered Features

- **Trend Forecasting**: Predicts market trends 2-3 months ahead
- **Opportunity Scoring**: Identifies promising customer segments
- **Action Recommendations**: Provides specific, actionable strategic advice

## Development

### Running Tests

```bash
php artisan test
```

### Code Style

```bash
composer run pint
```

### Building Assets

```bash
npm run dev
npm run build
```

## Contributing

1. Follow Laravel coding standards
2. Add tests for new features
3. Update documentation
4. Use meaningful commit messages

## License

MIT License - see LICENSE file for details.

## Support

For issues or questions:
- Check the `/python_scripts/README.md` for AI module setup
- Review Laravel logs in `/storage/logs/`
- Ensure Python dependencies are properly installed

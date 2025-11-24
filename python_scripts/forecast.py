#!/usr/bin/env python3
"""
AI Market Forecasting Script
This script handles time-series forecasting for market analysis.
Uses simple but effective methods to avoid Windows compatibility issues.
"""

import json
import sys
import pandas as pd
import numpy as np
import os

def main():
    if len(sys.argv) < 2:
        print(json.dumps({'error': 'Missing input file path'}))
        sys.exit(1)

    input_file = sys.argv[1]

    try:
        with open(input_file, 'r', encoding='utf-8') as f:
            input_data = json.load(f)

        data = input_data['data']
        periods = input_data.get('periods', 3)

        forecast_result = {}

        # Try to use Prophet, fallback to linear regression if failed
        try:
            # Try importing Prophet (this may fail on some systems)
            from prophet import Prophet
            print("Using Prophet for forecasting", file=sys.stderr)

            forecast_success = False
            if data and len(data) > 0:
                try:
                    df = pd.DataFrame(data)
                    if 'ds' not in df.columns:
                        # Create dates for monthly data
                        df['ds'] = pd.date_range(start='2024-01-01', periods=len(df), freq='M')
                    if 'y' not in df.columns and len(df.columns) > 1:
                        # Assume second column is the value
                        value_col = df.columns[1]
                        df['y'] = df[value_col]

                    # Ensure correct formats
                    df['ds'] = pd.to_datetime(df['ds'])
                    df['y'] = pd.to_numeric(df['y'], errors='coerce').fillna(0)

                    # Use Prophet
                    model = Prophet(
                        yearly_seasonality=True,
                        weekly_seasonality=False,
                        daily_seasonality=False,
                        changepoint_prior_scale=0.05
                    )

                    model.fit(df)
                    future = model.make_future_dataframe(periods=periods, freq='M')
                    forecast = model.predict(future)

                    # Extract data
                    forecast_result = {
                        'dates': forecast['ds'].tail(periods).dt.strftime('%Y-%m-%d').tolist(),
                        'predicted_values': forecast['yhat'].tail(periods).round(2).tolist(),
                        'lower_bounds': forecast['yhat_lower'].tail(periods).round(2).tolist(),
                        'upper_bounds': forecast['yhat_upper'].tail(periods).round(2).tolist(),
                        'growth_trend': (forecast['yhat'].iloc[-1] - forecast['yhat'].iloc[-periods]) / abs(forecast['yhat'].iloc[-periods]) if periods > 0 else 0,
                        'seasonal_index': forecast['multiplicative_terms'].tail(1).iloc[0] + 1 if 'multiplicative_terms' in forecast.columns else 1.0,
                        'method': 'prophet'
                    }
                    forecast_success = True

                except Exception as prophet_error:
                    print(f"Prophet failed, using fallback: {prophet_error}", file=sys.stderr)

            if not forecast_success:
                raise Exception("Prophet failed")

        except Exception as import_error:
            print(f"Using manual linear regression forecasting", file=sys.stderr)
            forecast_result = perform_simple_forecast(data, periods)

        print(json.dumps(forecast_result))

    except Exception as e:
        error_result = {
            'error': str(e),
            'traceback': str(sys.exc_info()[1]),
            'fallback_method': 'error_fallback'
        }
        print(json.dumps(error_result))
        sys.exit(1)

def perform_simple_forecast(data, periods):
    """Simple forecasting using manual calculations"""
    if data and len(data) > 0:
        df = pd.DataFrame(data)

        # Prepare data
        if 'y' not in df.columns and len(df.columns) > 1:
            df['y'] = pd.to_numeric(df.iloc[:, 1], errors='coerce').fillna(0)

        values = df['y'].dropna().values

        if len(values) > 1:
            # Manual linear regression
            x = np.arange(len(values))
            slope, intercept = np.polyfit(x, values, 1)
            growth_trend = slope / abs(np.mean(values)) if np.mean(values) != 0 else 0

            # Generate predictions
            future_x = np.arange(len(values), len(values) + periods)
            predictions = slope * future_x + intercept

            # Generate future dates
            last_date = pd.to_datetime(df.iloc[-1]['ds']) if 'ds' in df.columns else pd.Timestamp.now()
            future_dates = pd.date_range(start=last_date, periods=periods+1, freq='M')[1:]

            return {
                'dates': future_dates.strftime('%Y-%m-%d').tolist(),
                'predicted_values': predictions.round(2).tolist(),
                'lower_bounds': (predictions * 0.9).round(2).tolist(),
                'upper_bounds': (predictions * 1.1).round(2).tolist(),
                'growth_trend': min(max(growth_trend, -0.5), 0.5),
                'seasonal_index': 1.0,
                'method': 'manual_linear_regression'
            }
        else:
            # Single data point, use simple extrapolation
            base_value = float(values[0]) if len(values) > 0 else 50.0
            predictions = np.full(periods, base_value * 1.05)

            return {
                'dates': pd.date_range(start=pd.Timestamp.now(), periods=periods, freq='M').strftime('%Y-%m-%d').tolist(),
                'predicted_values': predictions.round(2).tolist(),
                'lower_bounds': (predictions * 0.95).round(2).tolist(),
                'upper_bounds': (predictions * 1.05).round(2).tolist(),
                'growth_trend': 0.05,
                'seasonal_index': 1.0,
                'method': 'simple_extrapolation'
            }
    else:
        # No data, generate baseline forecast
        predictions = np.full(periods, 90.0)

        return {
            'dates': pd.date_range(start=pd.Timestamp.now(), periods=periods, freq='M').strftime('%Y-%m-%d').tolist(),
            'predicted_values': predictions.round(2).tolist(),
            'lower_bounds': np.full(periods, 80.0).round(2).tolist(),
            'upper_bounds': np.full(periods, 100.0).round(2).tolist(),
            'growth_trend': 0.0,
            'seasonal_index': 1.0,
            'method': 'baseline_fallback'
        }

if __name__ == '__main__':
    main()

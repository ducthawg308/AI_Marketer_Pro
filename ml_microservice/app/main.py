from fastapi import FastAPI
from .routers import engagement_router, sentiment_router, optimize_router, anomaly_router, forecast_router

app = FastAPI(
    title="AI Marketer Pro ML Microservice",
    version="1.0.0",
    description="Microservice for ML predictions in AI Marketer Pro"
)

app.include_router(engagement_router)
app.include_router(sentiment_router)
app.include_router(optimize_router)
app.include_router(anomaly_router)
app.include_router(forecast_router)

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8001)

import asyncio
import os
from dotenv import load_dotenv

# Load .env
base_dir = os.path.dirname(os.path.abspath(__file__))
root_env = os.path.join(os.path.dirname(base_dir), ".env")
load_dotenv(root_env)

# Print key (censored partially)
key = os.getenv("GEMINI_API_KEY")
if key:
    print(f"API Key found: {key[:5]}...{key[-5:]}")
else:
    print("API Key NOT FOUND in env")

from services.market_intelligence import MarketResearchService

async def main():
    service = MarketResearchService()
    print("Sending request to Gemini...")
    res = await service.summarize_with_gemini("Say 'Hello, Gemini is working!'")
    print(f"Response: {res}")

if __name__ == "__main__":
    asyncio.run(main())

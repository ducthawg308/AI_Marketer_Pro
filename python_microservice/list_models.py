import asyncio
import os
import google.generativeai as genai
from dotenv import load_dotenv

# Load .env
base_dir = os.path.dirname(os.path.abspath(__file__))
root_env = os.path.join(os.path.dirname(base_dir), ".env")
load_dotenv(root_env)

key = os.getenv("GEMINI_API_KEY")
if not key:
    print("API Key NOT FOUND")
    exit(1)

genai.configure(api_key=key)

async def main():
    print("Available Gemini models:")
    try:
        for m in genai.list_models():
            if 'generateContent' in m.supported_generation_methods:
                print(f"- {m.name}")
    except Exception as e:
        print(f"Error listing models: {e}")

if __name__ == "__main__":
    asyncio.run(main())

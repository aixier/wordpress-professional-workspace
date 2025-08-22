# Build stage
FROM node:18.19.1 as builder

WORKDIR /app

# Install pnpm
RUN npm install -g pnpm

# First copy only package files
COPY package.json pnpm-lock.yaml ./

# Install dependencies
RUN pnpm install --frozen-lockfile

# Copy source code
COPY . .

# Build the application
RUN pnpm build

# Production stage
FROM node:18.19.1

WORKDIR /app

# Install pnpm
RUN npm install -g pnpm

# Copy package files and built files
COPY --from=builder /app/package.json /app/pnpm-lock.yaml ./
COPY --from=builder /app/.next ./.next
COPY --from=builder /app/public ./public
COPY --from=builder /app/next.config.mjs ./

# Install production dependencies
RUN pnpm install --prod --frozen-lockfile

# Set environment variables
ENV NODE_ENV="production"
ENV NEXT_TELEMETRY_DISABLED="1"

# Expose port
EXPOSE 3000

# Start the application
CMD ["pnpm", "start"]
-- NRLC AI Search Bible entitlements table
-- Run in Supabase/Postgres

CREATE EXTENSION IF NOT EXISTS pgcrypto;

CREATE TABLE IF NOT EXISTS entitlements (
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  user_id text NOT NULL,
  entitlement_key text NOT NULL,
  status text NOT NULL CHECK (status IN ('active', 'inactive')),
  stripe_customer_id text NULL,
  stripe_payment_intent_id text NULL,
  stripe_checkout_session_id text NULL,
  stripe_event_id_last text NULL,
  created_at timestamptz NOT NULL DEFAULT NOW(),
  updated_at timestamptz NOT NULL DEFAULT NOW()
);

CREATE UNIQUE INDEX IF NOT EXISTS entitlements_user_key_unique
  ON entitlements (user_id, entitlement_key);

CREATE INDEX IF NOT EXISTS entitlements_user_id_idx
  ON entitlements (user_id);

CREATE INDEX IF NOT EXISTS entitlements_entitlement_key_idx
  ON entitlements (entitlement_key);

CREATE INDEX IF NOT EXISTS entitlements_event_id_idx
  ON entitlements (stripe_event_id_last);

CREATE TABLE IF NOT EXISTS webhook_events (
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  stripe_event_id text NOT NULL UNIQUE,
  type text NOT NULL,
  received_at timestamptz NOT NULL DEFAULT NOW(),
  processed_ok boolean NOT NULL DEFAULT false,
  error_message text NULL,
  user_id text NULL,
  email text NULL,
  entitlement_key text NULL
);

CREATE INDEX IF NOT EXISTS webhook_events_received_at_idx
  ON webhook_events (received_at DESC);
